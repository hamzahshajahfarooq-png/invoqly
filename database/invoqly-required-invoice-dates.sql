begin;
create or replace function public.save_invoice_with_payment(
 p_invoice_id uuid,p_business_id uuid,p_client_id uuid,p_issue_date date,p_due_date date,
 p_currency text,p_language text,p_notes text,p_payment_instructions text,p_items jsonb,
 p_payment_state text,p_paid_date date
) returns uuid language plpgsql security invoker set search_path='' as $fn$
declare v_id uuid; v_path text;
begin
 if p_issue_date is null then raise exception 'Issue date is required'; end if;
 if p_payment_state='paid' and p_paid_date is null then raise exception 'Paid date is required'; end if;
 if p_payment_state='paid' and (p_paid_date<p_issue_date or p_paid_date>current_date) then raise exception 'Paid date must be on or after issue date and cannot be in the future'; end if;
 if p_payment_state is null or p_payment_state not in ('pending','paid') then raise exception 'Choose Pending or Paid'; end if;
 if p_payment_state='pending' and p_due_date is null then raise exception 'Pending invoices need a due date'; end if;
 v_id:=public.save_invoice_draft(p_invoice_id,p_business_id,p_client_id,p_issue_date,
  case when p_payment_state='paid' then null else p_due_date end,p_currency,p_language,p_notes,p_payment_instructions,p_items);
 select logo_path into v_path from public.businesses where id=p_business_id and user_id=auth.uid();
 if v_path is not null then
  if not exists(select 1 from public.business_logos where storage_path=v_path and business_id=p_business_id and user_id=auth.uid()) then raise exception 'Business logo is not registered'; end if;
  update public.invoices set seller_snapshot=seller_snapshot||jsonb_build_object('logo_path',v_path) where id=v_id;
 end if;
 if p_payment_state='paid' then perform public.mark_invoice_paid(v_id,p_paid_date); end if;
 return v_id;
end;$fn$;
revoke all on function public.save_invoice_with_payment(uuid,uuid,uuid,date,date,text,text,text,text,jsonb,text,date) from public,anon;
grant execute on function public.save_invoice_with_payment(uuid,uuid,uuid,date,date,text,text,text,text,jsonb,text,date) to authenticated;
commit;
