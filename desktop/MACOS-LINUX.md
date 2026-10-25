# macOS and Linux release preparation — 25 October 2026

## Current status

Source version 1.5.0 supports Windows, macOS and Linux. The public Windows download and update feed remain at 1.4.1. No macOS or Linux download has been advertised or published.

On this Windows host, a Linux x64 unpacked application was successfully built at `dist-linux-review-final/linux-unpacked/invoqly`. Its app archive passed the package audit (598 entries, no privileged credentials), and the executable's security fuses were checked. Creating an AppImage failed because the Windows host could not create required symlinks. The Linux executable cannot be run natively here. No macOS package was produced here.

## Generate installers with GitHub Actions

1. Commit and push the reviewed desktop source, lockfile, icons, build scripts, workflow and repository test fixtures. The workflow is `.github/workflows/desktop-macos-linux.yml`; it has been configured locally, not executed on GitHub during this task.
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

