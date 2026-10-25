# macOS and Linux release preparation — 25 October 2026

## Current status

Version 1.5.0 has now been built successfully on native GitHub macOS and Linux runners. The public Windows download and update feed remain at 1.4.1. The Mac packages are unsigned review builds, not Developer ID signed or notarized.

Downloads are published at https://invoqly.top/download/ . Linux update feeds are live; Mac update metadata is withheld until a signed release is available. The DEB installer provides desktop/protocol integration. For an AppImage, Google/browser return links need a desktop integration tool; email-code sign-in works without it. The download page explains this distinction.

Successful native run: https://github.com/hamzahshajahfarooq-png/invoqly/actions/runs/40177894746 . Both operating systems passed 11 unit tests, fictional email-code sign-in/invalid-code rejection, shader/reduced-motion checks, dashboard layout, Refresh/Updates controls, invoice PDF generation and billing-link handoffs. Both architecture packages passed archive audits. These checks do not establish real Google consent, physical printing or installation/update behavior on every OS version.

The original Windows-host AppImage attempt was blocked by symlink permissions. Native Linux runners solved this without changing Windows security settings. The Mac universal merge failed on framework signatures, so separate Intel and Apple Silicon packages are produced. A shader media-event timing issue was repaired; reduced-motion tests inspect actual rendered frame changes rather than unrelated native screen compositing.

## Generate installers with GitHub Actions

1. The reviewed desktop source and credential-free test assets were pushed to `codex/desktop-macos-linux-1-5` in an isolated checkout. The workflow is `.github/workflows/desktop-macos-linux.yml`. For future builds, commit and push reviewed changes; the branch push trigger starts a build. When the workflow is on the default branch, it can also be run manually.
2. Open Actions → **Build Invoqly for macOS and Linux** → **Run workflow**. Leave `sign_macos` disabled for an unsigned review build, or configure the signing secrets below and enable it for distribution.
3. Download `Invoqly-macOS` and `Invoqly-Linux` from the successful run. The Mac artifact contains separate Intel (x64) and Apple Silicon (ARM64) DMG and ZIP packages. Linux artifacts contain AppImage and DEB packages for x64 and ARM64, plus checksums and update metadata.
4. Test installation, Google/browser/email sign-in, MFA, encrypted restart, printing, PDF/CSV downloads, external billing links, reconnect, notifications and updates on actual supported operating systems. The workflow's layout tests use fictional data; they do not replace these native integration checks.
5. Publish tested installers and their generated metadata together under `/downloads/macos/` and `/downloads/linux/`. Preserve versioned files. Publish update metadata last. Do not publish an unsigned Mac update or metadata referencing unavailable files. Add website download links only after the packages are downloadable and verified.

No Supabase service-role key, payment secret or database credentials are needed in the build workflow. The existing production accounts and Google provider are reused.

## Local native builds

Use Node.js 24 and npm. On the target operating system, from `desktop/`:

```sh
npm ci
node node_modules/electron/install.js
npm test
npm run test:desktop
# macOS:
npm run build:mac
# Linux:
npm run build:linux
npm run audit:package
```

Audit the additional Linux ARM64 archive with `npm run audit:package -- dist/linux-arm64-unpacked/resources/app.asar`. Linux build dependencies are listed in the workflow. A Linux desktop needs GNOME Keyring or KWallet for persistent sessions. If a secure keyring is unavailable, the app explains that sign-in will not persist; it refuses plaintext token storage. macOS uses Keychain and Windows uses DPAPI.

## Signing and costs

For public Mac distribution, obtain a **Developer ID Application** certificate through the Apple Developer Program, export its private key as a password-protected P12, and set these repository Actions secrets:

- `MAC_CSC_LINK`: base64 P12 or its private certificate download URL.
- `MAC_CSC_KEY_PASSWORD`: P12 password.
- `APPLE_ID`: enrolled Apple account.
- `APPLE_APP_SPECIFIC_PASSWORD`: app-specific password for notarization.
- `APPLE_TEAM_ID`: developer team ID.

Enable `sign_macos` to sign with hardened runtime and request notarization. Never commit these credentials. Apple membership is currently **US$99 per year**, with regional pricing and taxes possible. See [Apple enrollment](https://developer.apple.com/programs/enroll/) and [Developer ID](https://developer.apple.com/developer-id/). No membership or certificate has been purchased during this work.

Linux direct AppImage/DEB distribution has no Apple-style signing enrollment charge. Package/repository signing may be added separately; HTTPS and checksums do not substitute for publisher signatures. Windows signing is described separately in `SIGNING.md`.

macOS updates require signed packages and the generated ZIP as well as the DMG. Each platform uses a separate feed. See [electron-builder platform builds](https://www.electron.build/v26/docs/features/multi-platform-build/) and [updates](https://www.electron.build/v26/docs/features/auto-update/).

