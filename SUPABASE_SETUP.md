# Supabase setup for Invoqly

The frontend authentication flow is implemented. It supports email/password
signup, email/password login, Google OAuth, session checks, and sign out.

## Values still needed

1. Create a Supabase project.
2. Open **Project Settings → API**.
3. Copy the project URL and the **publishable key**.
4. Put them in `assets/supabase-config.js`.

Never place a secret key or `service_role` key in this file. It is downloaded
by every visitor.

## URL configuration

In **Authentication → URL Configuration**, set:

- Site URL: `https://invoqly.hamzahshajahfarooq.workers.dev`
- Redirect URL: `https://invoqly.hamzahshajahfarooq.workers.dev/dashboard.html`
- Local redirect URL: `http://localhost:8070/dashboard.php`

## Google provider

In Google Cloud, create a **Web application** OAuth client.

- Authorized JavaScript origin:
  `https://invoqly.hamzahshajahfarooq.workers.dev`
- Authorized redirect URI: use the exact callback URL shown on Supabase’s
  **Authentication → Providers → Google** page. It normally follows:
  `https://YOUR_PROJECT.supabase.co/auth/v1/callback`

Paste the Google Client ID and Client Secret into the Supabase Google provider
settings. Do not add the Google Client Secret to this repository.

## Current dependency

The static pages load the browser build of `@supabase/supabase-js` pinned to
version `2.117.2`.
