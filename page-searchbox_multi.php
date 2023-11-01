<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <title>Search HathiTrust Catalog</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
    <style type="text/css">
      body,
      html {
        margin: 0;
        padding: 0;
      }
      img {
        width: auto;
        height: 100%;
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
    <main>
      <h1 class="offscreen">Search HathiTrust Digital Library Catalog</h1>
      <div
        style="
          display: flex;
          justify-content: space-between;
          height: 72px;
          width: 325px;
          border: 1px solid #ccc;
          padding: 6px;
          background-color: #fff;
        "
      >
        <img src="https://babel.hathitrust.org/common/firebird/dist/hathitrust-icon-orange.svg" alt="logo" />
        <!-- <div style="width: 145px; float: left; margin: 11px 12px 0px 0px"> -->
        <!-- <img src="/sites/www.hathitrust.org/partial/widgets/images/HathiTrust_WLogo_CatPrtnrs.png" height="47" width="145" alt="Hathi Trust Catalog Search" /> -->
        <div style="display: inline">
          <form
            method="get"
            action="https://catalog.hathitrust.org/Search/Home"
            name="HT_CatalogSearchForm_01"
            class="search"
            style="display: inline"
            target="_blank"
          >
            <div style="margin-bottom: 3px">
              <input type="hidden" name="checkspelling" value="true" />
              <input type="hidden" name="type" value="all" />
              <label for="lookfor" class="offscreen">Search Terms</label>
              <input
                class="searchterms"
                type="text"
                name="lookfor"
                value=""
                id="lookfor"
                style="font-size: 13px; width: 184px"
              />
              <button type="submit" name="submit" id="searchSubmit" style="font-size: 13px">Find</button>
            </div>
            <div style="margin-bottom: 3px">
              <label class="offscreen" for="searchtype">Field Name</label>
              <select id="searchtype" name="type" style="font-size: 13px">
                <option value="all">All Fields</option>
                <option value="title">Title</option>
                <option value="author">Author</option>
                <option value="subject">Subject</option>
                <!--<option value="hlb">Academic Discipline</option>-->
                <!--<option value="callnumber">Call Number / in progress</option>-->
                <option value="isn">ISBN/ISSN</option>
                <option value="publisher">Publisher</option>
                <option value="series">Series Title</option>
                <option value="year">Year of Publication</option>
                <!-- <option value="tag">Tag</option> -->
              </select>
              <input type="hidden" name="sethtftonly" value="true" />
              <input
                type="checkbox"
                name="htftonly"
                value="true"
                id="fullonly"
                checked="yes"
                style="position: relative; font-size: 13px"
              />&nbsp;<label
                for="fullonly"
                style="position: relative; font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12px"
                >Full view only</label
              >
            </div>
            <div style="margin-bottom: 2px">
              <label class="offscreen" for="searchfilter">Filter by Library</label>
              <select id="searchfilter" name="filter[]" style="font-size: 13px; width: 238px">
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
      </div>
    </main>
    <script type="text/javascript" src="/wp-content/themes/wordpress-hathitrust/src/js/matomo.js"></script>
  </body>
</html>
