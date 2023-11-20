<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Search HathiTrust Catalog</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
    <link rel="stylesheet" href="/wp-content/themes/wordpress-hathitrust/fonts.min.css" media="all">
    <style>
      body,
      html {
        margin: 0;
        padding: 0;
        font: 500 medium/1.31 Mulish, sans-serif;
      }
      button, select, input {
        font: 500 medium/1.31 Mulish, sans-serif;
        font-size:13px;
      }
      select {
        font-size:80%;
      }
      img {
        width: 6rem;
      }
      h1 {
        font-size:12.5px;
        line-height:1.1;
        margin:0;
        margin-block-end:3px;
      }
      .offscreen {
        position: absolute !important;
        height: 1px;
        width: 1px;
        overflow: hidden;
        clip: rect(1px 1px 1px 1px);
        clip: rect(1px, 1px, 1px, 1px);
      }
    </style>
  </head>
  <body>
    <main style="display:flex;max-height:90px;width:450px;gap:.5rem;">
        <img src="https://babel.hathitrust.org/common/firebird/dist/hathitrust-icon-orange.svg" alt="HathiTrust widget search">
        <div style="width:100%;">
          <h1>Search HathiTrust Digital Library Catalog</h1>
          <form method="get" action="https://catalog.hathitrust.org/Search/Home" name="HT_CatalogSearchForm_01" class="search" id="widget-catalog-multi" target="_blank">
              <div >
                <input type="hidden" name="checkspelling" value="true">
                <input type="hidden" name="type" value="all">
                <label for="lookfor" class="offscreen">Search Terms</label>
                <div style="display:flex;gap:5px;">
                  <input
                    class="searchterms"
                    type="text"
                    name="lookfor"
                    value=""
                    id="lookfor"
                    style="flex-grow:2" 
                  >
                  <button type="submit" name="submit" id="searchSubmit" >Find</button>
                </div>
              </div>
              <div style="display:flex;justify-content:space-between;gap:10px;margin-block:3px">
                <label class="offscreen" for="searchtype">Field Name</label>
                <select style="flex-grow:2" id="searchtype" name="type">
                  <option value="all">All Fields</option>
                  <option value="title">Title</option>
                  <option value="author">Author</option>
                  <option value="subject">Subject</option>
                  <option value="isn">ISBN/ISSN</option>
                  <option value="publisher">Publisher</option>
                  <option value="series">Series Title</option>
                  <option value="year">Year of Publication</option>
                </select>
                <div style="display:flex;align-items:center;gap:3px;">
                  <input type="hidden" name="sethtftonly" value="true">
                  <input
                    type="checkbox"
                    name="htftonly"
                    value="true"
                    id="fullonly"
                    checked="checked"
                  ><label
                    for="fullonly"
                    style="font-size:75%;"
                    >Full view only</label
                  >
                </div>
              </div>
            <div>
              <label class="offscreen" for="searchfilter">Filter by Library</label>
              <select style="width:100%" id="searchfilter" name="filter[]" >
                <option value="">All Libraries</option>
                <option value="htsource:Boston College">Boston College</option>
                <option value="htsource:Columbia University">Columbia University</option>
                <option value="htsource:Cornell University">Cornell University</option>
                <option value="htsource:Duke University">Duke University</option>
                <option value="htsource:Harvard University">Harvard University</option>
                <option value="htsource:Indiana University">Indiana University</option>
                <option value="htsource:Library of Congress">Library of Congress</option>
                <option value="htsource:Minnesota Digital Library">Minnesota Digital Library</option>
                <option value="htsource:New York Public Library">New York Public Library</option>
                <option value="htsource:North Carolina State University">North Carolina State University</option>
                <option value="htsource:Northwestern University">Northwestern University</option>
                <option value="htsource:Penn State University">Penn State University</option>
                <option value="htsource:Princeton University">Princeton University</option>
                <option value="htsource:Purdue University">Purdue University</option>
                <option value="htsource:Universidad Complutense de Madrid">Universidad Complutense de Madrid</option>
                <option value="htsource:University of California">University of California</option>
                <option value="htsource:University of Chicago">University of Chicago</option>
                <option value="htsource:University of Florida">University of Florida</option>
                <option value="htsource:University of Illinois">University of Illinois</option>
                <option value="htsource:University of Michigan">University of Michigan</option>
                <option value="htsource:University of Minnesota">University of Minnesota</option>
                <option value="htsource:University of North Carolina">University of North Carolina</option>
                <option value="htsource:University of Virginia">University of Virginia</option>
                <option value="htsource:University of Wisconsin">University of Wisconsin</option>
                <option value="htsource:Utah State University Press">Utah State University Press</option>
                <option value="htsource:Yale University">Yale University</option>
              </select>
            </div>
          </form>
        </div>
    </main>
    <script src="/wp-content/themes/wordpress-hathitrust/src/js/matomo.js"></script>
  </body>
</html>