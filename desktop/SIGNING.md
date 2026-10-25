# Windows code signing — separate from the desktop build

Pricing checked on 22 October 2026. Prices below are USD before taxes and can change.

The generated installer is unsigned unless signing credentials are explicitly supplied. Building with Electron/electron-builder has no licence fee. An unsigned installer can be tested locally, but Windows may show an unknown-publisher or SmartScreen warning. Signing identifies the publisher and detects tampering; it does not guarantee immediate SmartScreen reputation or eliminate every warning.

## Requirements

For public distribution, obtain a publicly trusted Authenticode code-signing certificate or a supported managed signing service. The provider validates the individual or organization. Modern code-signing keys normally live in approved hardware/HSM storage or a cloud signing service; buying a website TLS certificate is not sufficient. Timestamp both the application and installer during signing. Keep signing credentials outside the repository and packaged application.

The identity name accepted by the certificate provider appears as the publisher. Use that verified name when configuring `publisherName`; do not invent a company identity. No identity documents or signing keys are requested by this project.

## Cost examples

| Option | Listed cost | Additional considerations |
| --- | --- | --- |
| Unsigned build | $0 for the build tools | Useful for testing; no verified Windows publisher |
| Microsoft Azure Artifact Signing Basic | $9.99/month, includes 5,000 signatures | Identity validation, Azure paid subscription, and geography eligibility apply |
| SSL.com one-year IV/OV code-signing certificate | $129/year | Hardware token or cloud signing is additional |
| SSL.com eSigner IV/OV Tier 1 | $20/month or $180/year | Listed 20 signatures/month or 240/year; certificate subscription is separate |
| SSL.com listed FIPS token | $379 each | Shipping/tax and certificate cost may be additional |

Microsoft currently limits public-trust individual validation to the US and Canada. Its listed organization countries include the US, Canada, EU, UK, Australia, New Zealand, Japan, South Korea, Singapore, Switzerland, Norway, and Israel. **The UAE is not on that list** at the time checked. Do not buy that subscription assuming UAE eligibility. Confirm an alternative provider’s eligibility, individual/minor requirements, and full hardware/cloud charges before purchasing.

Official pricing and eligibility sources:

- [Microsoft Artifact Signing pricing](https://azure.microsoft.com/en-us/products/artifact-signing)
- [Microsoft eligibility and identity-validation prerequisites](https://learn.microsoft.com/en-gb/azure/artifact-signing/quickstart)
- [SSL.com certificate order pricing](https://secure.ssl.com/certificates/code-signing/buy)
- [SSL.com cloud signing prices](https://www.ssl.com/guide/esigner-pricing-for-code-signing/)
- [Microsoft notes that signing does not provide instant SmartScreen trust](https://learn.microsoft.com/en-us/windows/msix/package/sign-msix-package-guide)

## Build a signed release

This project uses electron-builder v26. Prefer its current Windows certificate-store, hardware-token, or Azure integration for the selected signing service. See the [v26 Windows configuration reference](https://www.electron.build/v26/docs/win/). Do not copy v27-only configuration into this pinned build.

For a certificate already installed in the Windows certificate store, configure a local build configuration with `win.signtoolOptions.certificateSubjectName` and `win.publisherName` matching its verified identity. For a legitimately exportable certificate, electron-builder supports `CSC_LINK` and `CSC_KEY_PASSWORD` environment variables. Modern non-exportable token/cloud certificates need their provider’s signing integration instead of a PFX file.

Example using an existing, supported exportable certificate (not a request to export a hardware-bound key):

```powershell
$env:CSC_LINK = 'C:\secure\publisher.pfx'
$env:CSC_KEY_PASSWORD = '<supply securely in your shell or CI secret store>'
npm run build:win
Get-AuthenticodeSignature .\dist\Invoqly-Setup.exe
Get-AuthenticodeSignature .\dist\win-unpacked\Invoqly.exe
```

Do not place real passwords into saved scripts. For public releases set `forceCodeSigning: true` in your release configuration so a missing certificate fails the build. Require Authenticode status `Valid` for both executable and installer, verify SHA-256 checksums, and test installation on a separate Windows machine before distributing. The supplied GitHub workflow deliberately builds unsigned; configure your chosen signing service and protected CI credentials before using it for a signed release.
