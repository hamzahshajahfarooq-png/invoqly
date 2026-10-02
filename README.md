# Invoqly — UAE E-Invoicing Landing Page

A single-file, production-ready landing page for the Invoqly e-invoicing compliance SaaS.
Everything (HTML, CSS, JS, EN/AR translations) lives in **`index.php`** — no build step, no dependencies, no database.

## Run locally

Requires PHP 7.4+:

```bash
cd invoqly
php -S localhost:8000
```

Then open http://localhost:8000 (Arabic: http://localhost:8000/?lang=ar).

## Deploy

Copy `index.php` to any PHP host (shared hosting, cPanel public_html, VPS, etc.) and you're done.
Google Fonts (Inter + IBM Plex Sans Arabic) load from CDN; everything else is self-contained.

## Language toggle (EN/AR)

- The **EN / عربي** buttons (navbar, mobile drawer, footer) switch every string instantly,
  flip the layout to RTL (`dir="rtl"`), and switch the font to IBM Plex Sans Arabic.
- Choice is persisted in `localStorage`.
- Server-side rendering also supports `?lang=ar` for shared links / crawlers.

## Hooking up the lead form

The modal form currently shows a demo success state. To make it real, find the
`Lead form (demo submit)` handler near the bottom of `index.php` and POST to your
endpoint (or use PHP `mail()`), e.g.:

```js
fetch('/leads.php', { method: 'POST', body: new FormData(form) })
```

## Notes

- All animations respect `prefers-reduced-motion`.
- No external images — all visuals are SVG/CSS.
- Semantic HTML, aria labels, keyboard: ESC closes the modal/drawer, focus states are visible.
