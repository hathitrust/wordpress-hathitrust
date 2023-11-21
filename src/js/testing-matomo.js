//use testing matomo for dev, staging sites
var _mtm = (window._mtm = window._mtm || []);
_mtm.push({ 'mtm.startTime': new Date().getTime(), event: 'mtm.Start' });
(function () {
  var d = document,
    g = d.createElement('script'),
    s = d.getElementsByTagName('script')[0];
  g.async = true;
  g.src = 'https://testing.matomo.hathitrust.org/js/container_JBgjlXyE.js';
  s.parentNode.insertBefore(g, s);
})();
