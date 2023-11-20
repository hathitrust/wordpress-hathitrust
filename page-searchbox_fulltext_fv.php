<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search HathiTrust Digital Library Full Text</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
<link rel="stylesheet" href="/wp-content/themes/wordpress-hathitrust/fonts.min.css" media="all"/>
<style type="text/css">
  body,
  html {
    margin: 0;
    padding: 0;
    font: 500 medium/1.31 Mulish, sans-serif;
  }
   button, input {
    font: 500 medium/1.31 Mulish, sans-serif;
    font-size:13px;
  }
  input[type="checkbox" i] {
    margin-inline-start:0;
  }
  img {
        width:55px;
        height:auto;
  }
  h1 {
    font-size:11.5px;
    line-height:1.1;
    margin: 0;
    margin-block-end:5px;
  }
  .offscreen {
    position: absolute !important;
    height: 1px;
    width: 1px;
    overflow: hidden;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px, 1px, 1px, 1px)
  }
</style>
<body>
  <main>
    <div style="display:flex;align-items:center;max-height:60px;max-width:300px;gap:7px;">
      <img src="https://babel.hathitrust.org/common/firebird/dist/hathitrust-icon-orange.svg" alt="HathiTrust search widget"/>
      <div style="">
        <h1>Search HathiTrust Digital Library Full Text</h1>
          <form name="searchcoll" action="https://babel.hathitrust.org/cgi/ls" id="HT_FullTextSearchForm_02" target="_blank">
              <input type="hidden" value="srchls" name="a"/>
              <label for="q" class="offscreen">Search Terms</label>
              <div style="display:flex;gap:5px;">
                <input class="searchterms" type="text" style="flex-grow:2" value="" name="q1" id="q"/>
                <button id="srch" type="submit">Find</button>
              </div>
              <div style="display:flex;align-items:center;margin-block-start:3px;gap:3px;">
                <input type="checkbox" value="ft" name="lmt" id="ls_fullonly" checked="checked" />
                <label for="ls_fullonly" style="position: relative; font-size: 75%;">Full view only</label>
                <input type="hidden" value="srchls" name="a"/>
              </div>
          </form>
        </div>
    </div>
  </main>
  <script type="text/javascript" src="/wp-content/themes/wordpress-hathitrust/src/js/matomo.js"></script>
</body>
</html>
