//use testing matomo for dev, staging sites
var _mtm = (window._mtm = window._mtm || []);
var _paq = (window._paq = window._paq || []);

if (getCookie('HT-tracking-cookie-consent') !== 'true') {
  _paq.push(['requireCookieConsent']);
} else {
  _paq.push(['setCookieConsentGiven']);
}

_mtm.push({ 'mtm.startTime': new Date().getTime(), event: 'mtm.Start' });
(function () {
  var d = document,
    g = d.createElement('script'),
    s = d.getElementsByTagName('script')[0];
  g.async = true;
  g.src = 'https://testing.matomo.hathitrust.org/js/container_JBgjlXyE.js';
  s.parentNode.insertBefore(g, s);
})();
