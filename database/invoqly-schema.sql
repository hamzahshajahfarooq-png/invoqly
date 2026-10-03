drop trigger if exists on_auth_user_created on auth.users;
drop table public.user_achievements, public.achievements, public.quiz_attempts, public.mistakes, public.flashcards, public.quiz_questions, public.study_sessions, public.daily_tasks, public.ai_usage_events, public.study_packs, public.exams, public.subjects, public.profiles cascade;
drop function if exists public.handle_new_user();
drop function if exists public.validate_mistake_references();
drop function if exists public.validate_owned_references();
drop function if exists public.complete_onboarding(text[],text,text,timestamptz);
drop function if exists public.consume_ai_quota(text,integer,integer);
drop function if exists public.save_generated_study_pack(text,text,text,jsonb,jsonb,jsonb,jsonb,jsonb,text,uuid,uuid);

create table public.businesses (
 id uuid primary key default gen_random_uuid(), user_id uuid not null default auth.uid() references auth.users(id),
 name text not null check(length(trim(name))>0), name_ar text, email text, phone text, address jsonb not null default '{}',
 logo_url text, tax_number text, currency text not null default 'USD' check(currency ~ '^[A-Z]{3}$'),
 language text not null default 'en' check(language in ('en','ar','bilingual')),
 created_at timestamptz not null default now(), unique(id,user_id)
);
create table public.clients (
 id uuid primary key default gen_random_uuid(), user_id uuid not null default auth.uid() references auth.users(id),
 business_id uuid not null, name text not null check(length(trim(name))>0), name_ar text, email text, phone text,
 address jsonb not null default '{}', tax_number text, notes text,
 created_at timestamptz not null default now(), unique(id,business_id,user_id),
 foreign key(business_id,user_id) references public.businesses(id,user_id)
);
create table public.invoice_sequences (
 business_id uuid primary key, user_id uuid not null default auth.uid(),
 last_number bigint not null default 0 check(last_number>=0),
 foreign key(business_id,user_id) references public.businesses(id,user_id)
);
create table public.invoices (
 id uuid primary key default gen_random_uuid(), user_id uuid not null default auth.uid() references auth.users(id),
 business_id uuid not null, client_id uuid, invoice_number text not null,
 status text not null default 'draft' check(status in ('draft','sent','partially_paid','paid','void')),
 issue_date date not null default current_date, due_date date, currency text not null default 'USD' check(currency ~ '^[A-Z]{3}$'),
 language text not null default 'en' check(language in ('en','ar','bilingual')),
 seller_snapshot jsonb not null default '{}', client_snapshot jsonb not null default '{}',
 notes text, payment_instructions text, created_at timestamptz not null default now(), updated_at timestamptz not null default now(),
 unique(business_id,invoice_number), unique(id,business_id,user_id),
 check(due_date is null or due_date>=issue_date),
 foreign key(business_id,user_id) references public.businesses(id,user_id),
 foreign key(client_id,business_id,user_id) references public.clients(id,business_id,user_id)
);
create table public.invoice_items (
 id uuid primary key default gen_random_uuid(), user_id uuid not null default auth.uid(),
 business_id uuid not null, invoice_id uuid not null, position integer not null default 1 check(position>0),
 description text not null, description_ar text, quantity numeric(14,4) not null default 1 check(quantity>0),
 unit_price numeric(18,4) not null check(unit_price>=0), tax_rate numeric(7,4) not null default 0 check(tax_rate between 0 and 100),
 discount_amount numeric(18,4) not null default 0 check(discount_amount>=0 and discount_amount<=quantity*unit_price),
 line_subtotal numeric generated always as (round(quantity*unit_price-discount_amount,2)) stored,
 line_tax numeric generated always as (round((quantity*unit_price-discount_amount)*tax_rate/100,2)) stored,
 foreign key(invoice_id,business_id,user_id) references public.invoices(id,business_id,user_id) on delete cascade
);
create table public.payments (
 id uuid primary key default gen_random_uuid(), user_id uuid not null default auth.uid(), business_id uuid not null,
 invoice_id uuid not null, amount numeric(18,2) not null check(amount>0), paid_at timestamptz not null default now(),
 method text, reference text, notes text,
 foreign key(invoice_id,business_id,user_id) references public.invoices(id,business_id,user_id)
);
create function public.assign_invoice_number() returns trigger language plpgsql security invoker set search_path='' as $fn$
declare seq bigint;
begin
 if new.invoice_number is null or trim(new.invoice_number)='' then
  insert into public.invoice_sequences(business_id,user_id,last_number) values(new.business_id,new.user_id,1)
  on conflict(business_id) do update set last_number=public.invoice_sequences.last_number+1 returning last_number into seq;
  new.invoice_number := 'INV-' || lpad(seq::text, greatest(6,length(seq::text)), '0');
 end if;
 return new;
end;
$fn$;
revoke all on function public.assign_invoice_number() from public,anon,authenticated;
create trigger assign_invoice_number before insert on public.invoices for each row execute function public.assign_invoice_number();
create trigger invoices_updated_at before update on public.invoices for each row execute function public.set_updated_at();
do $block$
declare t text;
begin
 foreach t in array array['businesses','clients','invoice_sequences','invoices','invoice_items','payments'] loop
  execute format('alter table public.%I enable row level security',t);
  execute format('revoke all on public.%I from anon, authenticated',t);
  execute format('grant select,insert,update,delete on public.%I to authenticated',t);
  execute format('create policy owner_access on public.%I for all to authenticated using ((select auth.uid())=user_id) with check ((select auth.uid())=user_id)',t);
  execute format('create index on public.%I(user_id)',t);
 end loop;
end;
$block$;
create index on public.clients(business_id,user_id);
create index on public.invoices(client_id,business_id,user_id);
create index on public.invoices(user_id,status,due_date);
create index on public.invoice_items(invoice_id,business_id,user_id);
create index on public.payments(invoice_id,business_id,user_id);
