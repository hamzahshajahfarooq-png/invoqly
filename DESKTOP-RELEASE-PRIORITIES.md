# Desktop release priorities

Updated 25 October 2026. Scope: direct downloads for macOS/Linux, existing Windows app and Supabase accounts. No database changes are required.

1. **Build real installers on native runners.** Keep release 1.5.0 separate from the live Windows 1.4.1 feed. Scan the selected build source before uploading, then run the isolated GitHub build branch. Linux targets: x64/ARM64 AppImage and DEB. Mac target: Intel and Apple Silicon DMG and ZIP packages. An unsigned Mac package is a review build; signing is a separate distribution decision.
2. **Verify the native packages.** Run unit, email sign-in, layout, PDF and billing-handoff checks with fictional data. Inspect package contents, security fuses and checksums. Record native test evidence and fix failures before publication. Real OAuth consent, printers and OS installer/update behavior need additional native verification.
3. **Publish verified direct downloads.** Keep immutable versioned packages. Add first-party platform download links only when actual packages are available and verified; never show a working-looking button for a missing installer.
4. **Enable each platform's update feed.** Upload packages before update metadata. Keep Windows/Mac/Linux feeds independent. macOS automatic updates require signing. Verify the app's update notification and explicit installation/restart behavior.
5. **Prepare public Mac signing.** Developer ID signing/notarization uses the owner's Apple membership and credentials. Do not purchase a membership or claim the package is notarized without those credentials. See desktop/MACOS-LINUX.md.

Customer tables, authentication providers, existing user data and current live download stay unchanged throughout build preparation.

