// Public website configuration only. The Google client secret and service-role
// key stay at Supabase / the existing server, never in the installer.
module.exports = Object.freeze({
  origin: 'https://invoqly.top',
  supabaseUrl: 'https://gugiuxcjovynshxnquih.supabase.co',
  publishableKey: 'sb_publishable_pUmr-dv_KBABzZWetU7Kuw_kay3_syy',
  storageKey: 'sb-gugiuxcjovynshxnquih-auth-token',
  callback: 'invoqly://auth/callback',
  appId: 'top.invoqly.desktop'
});
