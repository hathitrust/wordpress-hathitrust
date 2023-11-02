<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search HathiTrust Catalog</title>
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
    font-size:12px;
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
        <h1>Search HathiTrust Digital Library Catalog</h1>
        <form method="get" action="https://catalog.hathitrust.org/Search/Home" id="HT_CatalogSearchForm_03" name="HT_CatalogSearchForm_03" target="_blank">
              <input type="hidden" name="checkspelling" value="true"/>
              <input type="hidden" name="type" value="all"/>
              <label for="q" class="offscreen">Search Terms</label>
              <div style="display:flex;gap:5px;">
                <input style="flex-grow:2" class="searchterms" type="text" name="lookfor" value="" id="q"/>
                <button type="submit" name="submit" id="searchSubmit">Find</button>
              </div>
              <div style="display:flex;align-items:center;margin-block-start:3px;gap:3px;">
                <input type="hidden" name="sethtftonly" value="true"/>
                <input type="checkbox" name="htftonly" value="true" id="fullonly" checked="yes" />
                <label for="fullonly" style="position: relative; font-size: 75%;">Full view only</label>
              </div>
        </form>
      </div>

    </div>
  
</main>
<script type="text/javascript" src="/wp-content/themes/wordpress-hathitrust/src/js/matomo.js"></script>
</body></html>
