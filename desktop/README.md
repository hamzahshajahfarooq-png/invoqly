# Invoqly for Windows, macOS and Linux

The published Windows installer remains **1.4.1**. Source version **1.5.0** adds macOS/Linux packaging and platform-specific secure session storage; it is unreleased. See [macOS/Linux build instructions](MACOS-LINUX.md) for current build evidence, native testing requirements and signing setup.

**Current release: 1.4.1.** The centered sign-in card now sits over an animated emerald-and-olive WebGL shader. Rendering uses one fullscreen quad capped at 960×600 and at most 30 frames per second, pauses when hidden, respects reduced motion, and falls back to the existing static gradient when WebGL is unavailable. The decorative canvas cannot intercept clicks. Google, browser and email-code choices, the copyable sign-in link, and the signed-in Refresh/Updates controls remain available. See [the 1.4 release record](../DESKTOP-SIGNIN-RELEASE.md) for the underlying secure sign-in workflow.

The existing web source is stored at `C:\Users\Hamzah Ali Shajah\Documents\ps\invoqly`. This repository is a PHP-authored web application rendered to static pages, served by the Cloudflare Worker in `worker/`, with Supabase authentication and data. Key files: `auth-template.php`, `dashboard.php`, `assets/workspace.js`, `assets/supabase-config.js`, `worker/index.mjs`, and `build-static.ps1`.

The Electron source is in this `desktop/` directory. It opens the production HTTPS app at `https://invoqly.top/login` in its own sandboxed window. Existing users, invoices, clients, email delivery, TOTP configuration, billing, and RLS continue to use the existing production services. No service-role key, PayPal client secret, Paddle key, Google client secret, database dump, or `.secrets/` directory is packaged.

## Build and run

Requirements: 64-bit Windows with current Node.js 24 LTS and npm, internet access to npm/GitHub/Electron build downloads. A 64-bit installer is built for Windows 10/11 on x64; ARM64 and 32-bit installers are not produced. Windows 10 no longer receives normal Microsoft support; Windows 11 is recommended.

```powershell
cd 'C:\Users\Hamzah Ali Shajah\Documents\ps\invoqly\desktop'
npm ci
node node_modules/electron/install.js
npm test
npm run test:desktop
npm run build:win
npm run audit:package
```

Installer: `desktop/dist/Invoqly-Setup.exe`. Unpacked application: `desktop/dist/win-unpacked/Invoqly.exe`. The assisted installer supports a per-user installation, destination selection, desktop shortcut, and Start menu shortcut. The application has its own Invoqly icon and taskbar identity. Uninstall clears the app’s private profile; it does not delete any cloud data.

For development use `npm start`. Do not run development commands with an administrator account. `.github/workflows/desktop-windows.yml` provides the same build on GitHub’s Windows runner. Commit the desktop source, lockfile, icons, workflow, and the repository web-source/fictional fixtures used by the tests; push them to GitHub, run **Build Invoqly for Windows** from Actions, then download **Invoqly-Windows** from the completed run. Tagging `desktop-v1.0.0` also triggers it. No Supabase secrets or service credentials are required in CI.

Electron and the build tools are pinned in `package-lock.json`. Rebuild and distribute a new installer when shipping security updates. Desktop updates use the first-party HTTPS feed described below.

## Sign-in

- Email verification uses the existing web form and existing Supabase/Resend email delivery. Enter the emailed six-digit code in the desktop window. This does not create a separate desktop identity.
- Google Authenticator uses the same existing login endpoint and configured account factors. The website’s MFA checks remain in place.
- **Sign in with Google** opens the default system browser, using Supabase’s existing Google provider and Google client ID. The desktop main process generates a PKCE verifier, then exchanges the returning authorization code. The client secret stays at Supabase.
- Supabase’s existing redirect allowlist now additionally contains `invoqly://auth/callback`. Existing website redirects, site URL, and Google provider configuration were preserved. Google’s authorized callback remains `https://gugiuxcjovynshxnquih.supabase.co/auth/v1/callback`; no new Google OAuth client was created.
- Install and launch Invoqly once before testing Google so Windows has its `invoqly:` protocol handler. When the browser asks to open Invoqly, approve that handoff. Finish any existing MFA challenge inside Invoqly. Closing the desktop app during authorization cancels that attempt; start a fresh attempt after reopening.
- Google/browser consent, a real inbox verification, and a real authenticator code require the account owner. Automated tests use fictional identities; see the test report for what was exercised.

## Security and session storage

Remote pages run with `nodeIntegration: false`, `contextIsolation: true`, `sandbox: true`, `webSecurity: true`, no webviews, and restricted navigation/window creation. The preload exposes no Node, filesystem, arbitrary IPC, or token bridge to page JavaScript. Main-process messages verify the top-level webContents and origin. Certificate failures are not bypassed. Camera, microphone, geolocation, and clipboard-read permissions are denied. HTTPS/mailto links open outside the app; executable schemes and executable downloads are blocked.

Chromium’s app session is an in-memory partition, so its localStorage/cookies/cache are not deliberately persisted to disk by Electron. The app periodically snapshots only the known Supabase session storage key and saves it using Electron safeStorage’s Windows DPAPI protection. Successful sign-in is captured while the app runs and at orderly close; an immediate OS/process crash before capture may require signing in again. If OS encryption is unavailable, it does not fall back to plaintext session persistence. DPAPI protects against other Windows users, not malicious software already running as the same user. A Windows administrator or compromised endpoint can still access app memory.

On restart the saved tokens are restored through Supabase’s regular `setSession` flow and the existing dashboard performs its session/MFA checks. Signing out clears the encrypted snapshot. Tokens never appear in desktop callback URLs, CLI arguments, or test reports. The public Supabase URL and publishable key are intentionally client-visible; authorization still relies on the existing Supabase user session and policies.

## Printing, downloads, and offline use

The website’s **Print / save PDF** control uses the native print dialog. **App options (•••) → Print** / Ctrl+P does the same. **App options (•••) → Save invoice as PDF** / Ctrl+Shift+S directly generates a PDF with the existing invoice print styles and asks where to save it. Open an invoice first. Other PDF/CSV downloads use a native save dialog. No downloaded file is opened or executed automatically.

Without a network connection, the local branded reconnect page explains what happened and offers **Try again**. Cloud data is not edited offline. The app reconnects when the network returns; it does not claim to sync offline changes. The website may also show its own connection/retry message when an API request fails after the page has already loaded.

## Tests and artifacts

`npm test` checks origin restrictions, external schemes, callback validation, download names, and bounded session parsing. `npm run test:desktop` launches actual Electron windows with the existing web login/dashboard HTML and fictional backend adapters. It exercises email-code UI, invalid-code rejection, authenticator login, encrypted persistence and restore, real SDK PKCE generation/exchange against a local test endpoint, OAuth MFA continuation, PDF bytes, download save handling, external links, sandbox settings, and offline/retry. The native printer dispatch is tested with a substitute printer callback; physical printing requires a connected printer and manual confirmation.

`test-output/report.json` records completed desktop flows. `test-output-provider.json` records the unauthenticated live provider check, including confirmation that Google’s client ID is unchanged. Tests never send real verification emails, perform a real Google login, or write production user records. `npm run audit:package` inspects `app.asar` to ensure private workspace directories and privileged keys are absent.

An npm audit of production dependencies returned zero vulnerabilities during initial setup. Current electron-builder transitive development dependencies include a moderate `sprintf-js` advisory with no patched release available at that time; they are not included in the installed application. Recheck npm audit when updating the build toolchain.

For signing requirements, current costs, and production signing steps, see [SIGNING.md](SIGNING.md). No certificate or paid signing subscription is purchased by the build.

## Updates and website downloads

The installed app has an **Updates** menu. It checks 15 seconds after launch and every four hours while running. A native Windows notification announces new versions and downloaded updates, subject to Windows notification/Do Not Disturb settings. It does not run a background service after exiting. Downloads and restart/install require user choices; nothing silently restarts the app. Web features appear on reload using the same live backend. No school demo is added to the app.

The pinned generic feed is `https://invoqly.top/downloads/windows/latest.yml`. Installer metadata includes SHA-512 validation; the initial unsigned release cannot verify a publisher signature. Sign future releases and configure the certificate publisher before distributing to a wider audience. The website offers `/download/` and `/download.exe`; the downloaded filename is `Invoqly-Setup.exe`. Immutable installers are split into static assets and reassembled by `worker/desktop-download.mjs`, including byte-range support. No additional database/storage service is needed.

For a new release, increase the version in desktop/package.json and lockfile, run tests/build/audit, then upload the new installer parts plus versioned manifest/checksum and replace latest.yml **last**, after confirming the download hash. Keep previous versioned parts available. Use tools/prepare-desktop-release.mjs for the initial reviewed production snapshot; future publication must snapshot the then-current live assets and Worker, rather than restoring an older web release. The Windows workflow produces installer, metadata and checksum artifacts for publication; it does not automatically deploy the website.

## Desktop layout

Version 1.0.1 adds app-only presentation: a forest desktop toolbar (Workspace, Refresh, Updates), a compact sidebar, a desktop sign-in layout, and no marketing footer or Windows download panel. Home links remain within sign-in/workspace; Help → Website opens the ordinary website externally. The website keeps its existing layout and has one Install for Windows section after the process. Styles live in src/desktop.css and are injected only into the app’s trusted top-level pages.

## Version 1.0.2 presentation

The app now preserves the live website’s layout, typography, decorative panels and animations. The native File/Edit menu and previous full-width Windows toolbar are removed. Refresh and Updates remain visible in the existing website header, with a compact fallback control group on standalone pages; the adjacent ••• button opens printing, PDF export and support actions. Existing keyboard shortcuts remain. Landing-page navigation is available, while Windows installation links are hidden inside the already installed app. The website itself is unchanged.

## Version 1.3.0

PayPal monthly/yearly subscriptions use the same production billing endpoints
and server-enforced entitlements as the website. Hosted PayPal approval and
automatic-payment management open in the system browser without replacing the
signed-in app window. Use Refresh billing status after completing payment.
The website design, Refresh, Updates, printing, downloads, sign-in, offline screen,
icon and account data remain available.

The public installer and latest.yml update feed publish version 1.3.0. Older
1.0.0/1.0.1/1.0.2 clients are checked against the real update feed. Automatic
checks run while the installed app is open; download/restart require a user
choice. See ../PAYPAL-BILLING.md for security rules and payment-test limitations.
