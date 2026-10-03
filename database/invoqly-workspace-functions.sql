create or replace function public.save_invoice_draft(
 p_invoice_id uuid, p_business_id uuid, p_client_id uuid, p_issue_date date,
 p_due_date date, p_currency text, p_language text, p_notes text,
 p_payment_instructions text, p_items jsonb
) returns uuid language plpgsql security invoker set search_path='' as $fn$
declare v_business public.businesses; v_client public.clients; v_invoice public.invoices; v_id uuid; x jsonb; pos integer:=0;
begin
 if auth.uid() is null then raise exception 'Authentication required'; end if;
 select * into strict v_business from public.businesses where id=p_business_id and user_id=auth.uid() for update;
 select * into strict v_client from public.clients where id=p_client_id and business_id=p_business_id and user_id=auth.uid();
 if p_items is null or jsonb_typeof(p_items) <> 'array' or jsonb_array_length(p_items) not between 1 and 100 then raise exception 'Invoice needs 1 to 100 line items'; end if;
 if p_due_date < p_issue_date then raise exception 'Due date cannot precede issue date'; end if;
 if p_currency !~ '^[A-Z]{3}$' or p_language not in ('en','ar','bilingual') then raise exception 'Invalid currency or language'; end if;
 if p_invoice_id is null then
  insert into public.invoices(business_id,user_id,client_id,invoice_number,issue_date,due_date,currency,language,notes,payment_instructions,seller_snapshot,client_snapshot)
  values(p_business_id,auth.uid(),p_client_id,'',p_issue_date,p_due_date,p_currency,p_language,p_notes,p_payment_instructions,
   jsonb_build_object('name',v_business.name,'name_ar',v_business.name_ar,'email',v_business.email,'phone',v_business.phone,'address',v_business.address,'tax_number',v_business.tax_number,'logo_url',v_business.logo_url),
   jsonb_build_object('name',v_client.name,'name_ar',v_client.name_ar,'email',v_client.email,'phone',v_client.phone,'address',v_client.address,'tax_number',v_client.tax_number)) returning id into v_id;
 else
  select * into strict v_invoice from public.invoices where id=p_invoice_id and business_id=p_business_id and user_id=auth.uid() for update;
  if v_invoice.status <> 'draft' then raise exception 'Only drafts can be edited'; end if;
  v_id:=p_invoice_id;
  update public.invoices set client_id=p_client_id,issue_date=p_issue_date,due_date=p_due_date,currency=p_currency,language=p_language,notes=p_notes,payment_instructions=p_payment_instructions,
   seller_snapshot=jsonb_build_object('name',v_business.name,'name_ar',v_business.name_ar,'email',v_business.email,'phone',v_business.phone,'address',v_business.address,'tax_number',v_business.tax_number,'logo_url',v_business.logo_url),
   client_snapshot=jsonb_build_object('name',v_client.name,'name_ar',v_client.name_ar,'email',v_client.email,'phone',v_client.phone,'address',v_client.address,'tax_number',v_client.tax_number)
  where id=v_id;
  delete from public.invoice_items where invoice_id=v_id;
 end if;
 for x in select value from jsonb_array_elements(p_items) loop
  pos:=pos+1;
  if length(trim(coalesce(x->>'description',''))) not between 1 and 500 then raise exception 'Description must be 1 to 500 characters'; end if;
  insert into public.invoice_items(business_id,user_id,invoice_id,position,description,description_ar,quantity,unit_price,tax_rate,discount_amount,currency_precision)
  values(p_business_id,auth.uid(),v_id,pos,trim(x->>'description'),x->>'description_ar',(x->>'quantity')::numeric,(x->>'unit_price')::numeric,coalesce((x->>'tax_rate')::numeric,0),coalesce((x->>'discount_amount')::numeric,0),public.currency_minor_units(p_currency));
 end loop;
 return v_id;
end;
$fn$;
revoke all on function public.save_invoice_draft(uuid,uuid,uuid,date,date,text,text,text,text,jsonb) from public,anon;
grant execute on function public.save_invoice_draft(uuid,uuid,uuid,date,date,text,text,text,text,jsonb) to authenticated;

create or replace function public.record_invoice_payment(p_invoice_id uuid,p_amount numeric,p_paid_at timestamptz,p_method text,p_reference text)
returns uuid language plpgsql security invoker set search_path='' as $fn$
declare v_invoice public.invoices; v_total numeric; v_paid numeric; v_id uuid;
begin
 if auth.uid() is null then raise exception 'Authentication required'; end if;
 select * into strict v_invoice from public.invoices where id=p_invoice_id and user_id=auth.uid() for update;
 if v_invoice.status in ('draft','void','paid') then raise exception 'Invoice is not open for payment'; end if;
 select coalesce(sum(line_subtotal+line_tax),0) into v_total from public.invoice_items where invoice_id=p_invoice_id;
 select coalesce(sum(amount),0) into v_paid from public.payments where invoice_id=p_invoice_id;
 if p_amount is null or p_amount <= 0 or round(p_amount,public.currency_minor_units(v_invoice.currency)) <> p_amount or p_amount > v_total-v_paid then raise exception 'Invalid payment amount or amount exceeds balance'; end if;
 if p_paid_at is null or p_paid_at > now()+interval '1 day' then raise exception 'Invalid payment date'; end if;
 if p_method not in ('bank_transfer','cash','card','other') then raise exception 'Invalid payment method'; end if;
 insert into public.payments(business_id,user_id,invoice_id,amount,paid_at,method,reference)
 values(v_invoice.business_id,auth.uid(),p_invoice_id,p_amount,p_paid_at,p_method,p_reference) returning id into v_id;
 update public.invoices set status=case when v_paid+p_amount>=v_total then 'paid' else 'partially_paid' end where id=p_invoice_id;
 return v_id;
end;
$fn$;
revoke all on function public.record_invoice_payment(uuid,numeric,timestamptz,text,text) from public,anon;
grant execute on function public.record_invoice_payment(uuid,numeric,timestamptz,text,text) to authenticated;
