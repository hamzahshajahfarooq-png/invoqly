# Invoqly workspace

The workspace is authored in `dashboard.php`, with browser interactions in `assets/workspace.js` and styling in `assets/workspace.css`. No React, TSX or TypeScript is required. PHP renders the Cloudflare static build; Supabase Auth and the Data API provide account-specific data under row-level security.

## Screens

- `dashboard.php#overview`: actual totals, recent invoices and setup checklist.
- `dashboard.php#invoices`: searchable invoice list and status filters.
- `dashboard.php#editor`: new invoice, line items, tax and automatic numbering.
- `dashboard.php#editor/{id}`: edit an existing draft.
- `dashboard.php#invoice/{id}`: invoice preview, issue, print / browser PDF export.
- `dashboard.php#clients` and `#client/new`: client records and editing.
- `dashboard.php#payments`: manual payment recording and history.
- `dashboard.php#reports`: currency-separated totals and CSV export.
- `dashboard.php#profile`: name, account information, recovery email and sign-out.
- `dashboard.php#settings`: seller details, logo URL, default currency and appearance.
- `dashboard.php#help`: onboarding and product boundaries.

The interface and invoice fields are English only. Old Arabic URL aliases render the English screens so existing authentication redirects continue to work. Previously saved Arabic data remains in the database; the UI does not collect it.

## Currencies

`assets/currencies.js` contains 165 current ISO 4217 monetary currencies from SIX, retrieved October 3, 2026. The picker is searchable and uses self-hosted SVG flags. Shared international currencies use a globe, and the euro uses the EU flag. Totals, payment validation and CSV export honor each currency's minor-unit precision (0–4 decimals). Reports keep currencies separate; no currency conversion is performed.

## Database

The deployed database already has the core tables and profile triggers. The workspace adds invoker functions for atomically saving invoice drafts and recording payments. `database/invoqly-currency-precision.sql` applies the precision update and current workspace functions in a transaction. It preserves existing item inputs and expands payment storage to four decimals. Existing invoice items keep their original two-decimal precision; new saves use the selected currency's precision.

Do not rerun `database/invoqly-schema.sql` against the current project: it is the historical Studexa replacement script. `database/verify-workspace.sql` runs isolated assertions in a transaction and rolls back all test data. Checks cover numbering, totals, atomic rollback, partial/full payment status, excess payment rejection, JPY/KWD precision and cross-account isolation.

## Local and deployment

Run `php -S localhost:8070` and open `http://localhost:8070/dashboard.php` after signing in locally. Run `./build-static.ps1` before committing a deployment. The build copies nested flag assets and renders compatibility aliases from PHP. Cloudflare serves `public/`; it does not execute PHP.

The local `.vendor/workspace-preview.php` QA fixture, if present, is excluded from Git and deployment. Its example data is not production data.

## Current scope

Payments are records of money received, not transactions. Issuing an invoice changes its status but does not email it or submit it to a government system. PDF export uses the browser print dialog. Business logo inputs accept public HTTPS image URLs; upload storage is not implemented. There is one business per workspace in this release, no paid subscription checkout, team management or public invoice-sharing links.

## Paid invoices and business logos
- Invoice editor offers Pending (due date required) or Paid (payment date, no due date).
- Paid saves finalize the invoice and record its full payment atomically. Issued invoices also support marking the remaining balance as paid.
- The Editorial invoice design is used for preview and browser Print / save PDF, including payment status/date, recorded payments and balance.
- Business settings accept PNG/JPG/WebP uploads up to 2 MB. `business_logos` stores owner-scoped metadata; the private `business-logos` bucket holds the files. Invoice snapshots retain the uploaded logo path. Signed URLs are refreshed for printing; replacing a logo preserves older invoice logos.
- Apply `database/invoqly-paid-and-logos.sql` once on an existing Invoqly schema. `database/verify-paid-and-logos.sql` verifies payments, dates, snapshots and isolation in a rolled-back transaction.
- Verification included database integration checks and a mocked local browser fixture for Paid/Pending controls, preview and upload UI. The fixture does not perform a real Storage upload.
