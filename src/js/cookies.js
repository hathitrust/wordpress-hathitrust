function getCookie(sKey) {
  if (!sKey) {
    return null;
  }
  return (
    decodeURIComponent(
      document.cookie.replace(
        new RegExp(
          '(?:(?:^|.*;)\\s*' + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=\\s*([^;]*).*$)|^.*$'
        ),
        '$1'
      )
    ) || null
  );
}

function setCookie(sKey, sValue, vEnd, sPath, sDomain, bSecure) {
  if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
    return false;
  }
  var sExpires = '';
  if (vEnd) {
    switch (vEnd.constructor) {
      case Number:
        sExpires = vEnd === Infinity ? '; expires=Fri, 31 Dec 9999 23:59:59 GMT' : '; max-age=' + vEnd;
        break;
      case String:
        sExpires = '; expires=' + vEnd;
        break;
      case Date:
        sExpires = '; expires=' + vEnd.toUTCString();
        break;
    }
  }
  document.cookie =
    encodeURIComponent(sKey) +
    '=' +
    encodeURIComponent(sValue) +
    sExpires +
    (sDomain ? '; domain=' + sDomain : '') +
    (sPath ? '; path=' + sPath : '') +
    (bSecure ? '; secure' : '');
  return true;
}

function removeCookie(sKey, sPath, sDomain) {
  if (!this.hasItem(sKey)) {
    return false;
  }
  document.cookie =
    encodeURIComponent(sKey) +
    '=; expires=Thu, 01 Jan 1970 00:00:00 GMT' +
    (sDomain ? '; domain=' + sDomain : '') +
    (sPath ? '; path=' + sPath : '');
  return true;
}

function loadYouTubeVideo() {
  if (window.location.pathname !== '/') {
    return;
  }

  let placeholder = document.querySelector('.yt-no-consent');

  if (!placeholder) {
    return;
  }

  let youtubeVideo = document.querySelector('.home-pres iframe');
  let youtubeSrc = youtubeVideo.getAttribute('data-cookieblock-src');

  youtubeVideo.src = youtubeSrc;
  youtubeVideo.removeAttribute('data-cookieblock-src');
  placeholder.remove();
}

function loadMapEmbed() {
  if (!window.location.pathname.includes('member-list')) {
    return;
  }
  let map = document.querySelector('#member-map');
  let mapFrame = document.querySelector('#member-map iframe');
  let mapSrc = 'https://www.google.com/maps/d/embed?mid=1-TEZOo6q2UueZ3Gq_G6zWWWzUa0SuX3m&amp;ehbc=2E312F';

  map.style.display = 'block';
  mapFrame.src = mapSrc;
}

function handleMarketingConsent() {
  const expiration = new Date();
  expiration.setMonth(expiration.getMonth() + 12);

  HT = window.HT || {};

  if (getCookie('HT-marketing-cookie-consent') === 'false') {
    setCookie('HT-marketing-cookie-consent', 'true', expiration, '/', HT.cookies_domain, true);
  }
  loadYouTubeVideo();
  loadMapEmbed();
}

function checkForCookies() {
  // console.log('marketing', getCookie('HT-marketing-cookie-consent'));
  // console.log('tracking', getCookie('HT-tracking-cookie-consent'));

  if (getCookie('HT-marketing-cookie-consent') === 'true') {
    loadYouTubeVideo();
    loadMapEmbed();
  }
  if (getCookie('HT-tracking-cookie-consent') === 'true') {
    var _paq = (window._paq = window._paq || []);

    //make sure the matomo cookies aren't already set
    _paq.push([
      function () {
        if (this.areCookiesEnabled()) {
          console.log('matomo cookies already enabled');
          return;
        } else {
          console.log('matomo cookies not set yet, pushing setCookieConsentGiven now');
          _paq.push(['setCookieConsentGiven']);
        }
      },
    ]);
  }
}
//no matter where I put the script (it's currently the last script before the footer), the cookie banner element
//was too slow being injected in the DOM, even with addEventListener("DOMContentLoaded").
//1.5 seconds seems to be long enough for the banner to be in the DOM
setTimeout(() => {
  let cookieBanner = document.querySelector('.cookie-banner');
  let cookieSettings = document.querySelectorAll('.settings-buttons button')[1];

  if (cookieBanner) {
    cookieBanner.addEventListener('click', checkForCookies);
  }
  if (cookieSettings) {
    cookieSettings.addEventListener('click', checkForCookies);
  }
}, 2000);

checkForCookies();
