<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Search HathiTrust Catalog</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
<link rel="stylesheet" href="/wp-content/themes/wordpress-hathitrust/fonts.min.css" media="all"/>
<!-- <link rel="stylesheet" href="/wp-content/themes/wordpress-hathitrust/dist/css/style.min.css" media="all"/> -->
<style type="text/css">
  body,
  html {
    margin: 0;
    padding: 0;
    font: 500 medium/1.31 Mulish, sans-serif;
  }
  button, input {
    font: 500 medium/1.31 Mulish, sans-serif;
    margin:0;
  }
  /* img {
        width: auto;
        height: 5rem;
        padding: 1rem;
      } */

  
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
  <main style="display:flex;width:290px;height:26px;gap:3px;">
      <img src="https://babel.hathitrust.org/common/firebird/dist/cropped-favicon-180x180.png" alt="HathiTrust search widget"/>
        <h1 class="offscreen">Search HathiTrust Digital Library Catalog</h1>
        <form style="display:flex;gap:3px" method="get" action="https://catalog.hathitrust.org/Search/Home" id="HT_CatalogSearchForm_02" name="HT_CatalogSearchForm_02" target="_blank">
            <input type="hidden" name="checkspelling" value="true"/>
            <input type="hidden" name="type" value="all"/>
            <label for="q" class="offscreen">Search Terms</label>
            <input style="width:100%" class="searchterms" type="text" name="lookfor" value="" id="q"/>
            <button type="submit" name="submit" id="searchSubmit">Find</button>
        </form>
  
</main>
  <script type="text/javascript" src="/wp-content/themes/wordpress-hathitrust/src/js/matomo.js"></script>
</body></html>
