create table public.profiles (
 id uuid primary key references auth.users(id) on delete cascade,
 full_name text,
 preferred_language text not null default 'en' check(preferred_language in ('en','ar')),
 created_at timestamptz not null default now(),
 updated_at timestamptz not null default now()
);
alter table public.profiles enable row level security;
revoke all on public.profiles from anon,authenticated;
grant select,insert,update on public.profiles to authenticated;
create policy own_profile_read on public.profiles for select to authenticated using((select auth.uid())=id);
create policy own_profile_insert on public.profiles for insert to authenticated with check((select auth.uid())=id);
create policy own_profile_update on public.profiles for update to authenticated using((select auth.uid())=id) with check((select auth.uid())=id);
create schema if not exists private;
revoke all on schema private from public,anon,authenticated;
create function private.create_invoqly_profile() returns trigger language plpgsql security definer set search_path='' as $fn$
begin
 insert into public.profiles(id,full_name) values(new.id,left(coalesce(new.raw_user_meta_data->>'full_name',new.raw_user_meta_data->>'name',''),200)) on conflict(id) do nothing;
 return new;
end;
$fn$;
revoke all on function private.create_invoqly_profile() from public,anon,authenticated;
create trigger on_auth_user_created after insert on auth.users for each row execute function private.create_invoqly_profile();
create trigger profiles_updated_at before update on public.profiles for each row execute function public.set_updated_at();
insert into public.profiles(id,full_name) select id,left(coalesce(raw_user_meta_data->>'full_name',raw_user_meta_data->>'name',''),200) from auth.users on conflict(id) do nothing;
