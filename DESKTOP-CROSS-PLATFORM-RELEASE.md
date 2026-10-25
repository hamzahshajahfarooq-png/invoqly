# Invoqly Mac and Linux release — 25 October 2026

## Priority and completion evidence

1. **Native builds: passed.** GitHub run [40177894746](https://github.com/hamzahshajahfarooq-png/invoqly/actions/runs/40177894746) built macOS Intel/Apple Silicon DMG and ZIP packages, and Linux x64/ARM64 AppImage and DEB packages. Source commit: `f912cb3369f4c90c37efbed75cc192b0114afadb`, branch `codex/desktop-macos-linux-1-5`.
2. **Automated verification: passed.** Both native runners passed 11 security/platform unit tests, fictional email verification and invalid-code rejection, login shader/reduced motion, dashboard controls, invoice PDF creation and subscription/billing link handoffs. Both architecture archives passed package scans. All eight installer SHA-256 values were checked against native-runner checksum files before upload. Uploaded asset sizes and available GitHub SHA-256 digests are checked before release publication.
3. **Direct downloads: published.** [Invoqly downloads](https://invoqly.top/download/) links to all platform installers. The publication record is `.vendor/native-desktop-artifacts/release-record.json`. The website source page is generated only from that verified release record. Desktop/mobile layout, all eight installer links, file sizes and the unsigned Mac notice were checked. Draft release URLs were refreshed after publication to avoid stale temporary links.
4. **Updates: Linux feed published; Windows retained.** Version-specific installer assets are hosted in the [public release](https://github.com/hamzahshajahfarooq-png/invoqly/releases/tag/desktop-macos-linux-v1.5.0) and linked from Invoqly's download page. Linux update metadata is served under the first-party `/downloads/linux/` feed with absolute immutable asset URLs and validated SHA-512 values. Windows remains 1.4.1. Mac metadata is deliberately withheld because these builds lack Developer ID signing/notarization. A real future Linux update installation has not yet been exercised.
5. **Mac signing: awaits owner credentials.** No paid membership or certificate has been purchased. Unsigned review downloads are clearly identified; macOS may block opening them. Signing details are in `desktop/MACOS-LINUX.md`.

## Repairs made while building

- Windows could not create the symlinks required for AppImage packaging. Native Linux runners produced the installers without lowering Windows security settings.
- Universal Mac merging failed on architecture-specific Electron framework signatures. Separate Intel and Apple Silicon installers avoid that merge while preserving hardening.
- A delayed native reduced-motion event could leave the shader's motion indicator stale. The animation loop now synchronizes it when stopping. Tests measure actual render-frame stability, avoiding unrelated native screenshot compositing changes.
- The initially isolated CI snapshot lacked the download module imported by a unit test. Its credential-free source was added, and the complete suite passed.

## Data, accounts and limits

No SQL query, migration, table deletion or customer-data change was needed for this desktop release. Existing Supabase accounts, Google provider/client ID and production data are reused. Only public client configuration is packaged. Session storage uses Windows DPAPI, macOS Keychain or an approved Linux keyring; Linux plaintext fallback is refused.

Runtime tests ran on each native runner's architecture. Packages for the other CPU architecture were built and archive-audited, not separately runtime-tested. Real Google consent, physical printers, OS installation dialogs and an actual future update installation remain manual integration checks. No real email, charge or refund was triggered by these tests.

The DEB package supplies Linux desktop/protocol registration. An AppImage does not install a desktop entry automatically: browser/Google return links need desktop integration, while email-code sign-in remains available without it. This is explained on the download page. See the [electron-builder AppImage documentation](https://www.electron.build/v26/docs/appimage/). Native AppImage integration and end-to-end OS installer/update verification remain next priorities before describing every Linux sign-in route as fully verified.

## Source and evidence

- Desktop source: `desktop/`.
- Workflow: `.github/workflows/desktop-macos-linux.yml`.
- Priorities: `DESKTOP-RELEASE-PRIORITIES.md`.
- Native screenshots and downloaded build artifacts: `.vendor/native-desktop-artifacts/` (not bundled or committed).
- Download page generator: `tools/prepare-native-download-page.mjs`.
- Publication/checksum tool: `tools/publish-native-desktop.mjs`.
- Desktop/mobile and live-link checks: `tools/check-native-downloads.mjs`.
