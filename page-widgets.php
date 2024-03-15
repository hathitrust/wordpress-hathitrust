<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

			get_template_part( 'inc/breadcrumbs' );

            $override = get_field( 'title_override' );
			$title = $override ? $override : get_the_title();

			

?>
<div class="twocol">
    <div class="twocol-side">
            <h1><?= wp_kses_post( $title ); ?></h1>
    <?php

                if ( have_rows( 'sidebar_blocks' ) ) {
                    while ( have_rows( 'sidebar_blocks' ) ) { the_row();
                        get_template_part( 'inc/sidebar-block', get_row_layout() );
                    }
                }

    ?>
	</div>
	<div class="twocol-main" id="page-content">
		<div class="mainplain">
        <?php

			the_content();

            if ( have_rows( 'main_blocks' ) ) {
				$i = 0;
				while ( have_rows( 'main_blocks' ) ) { the_row();
					$i++;
					get_template_part( 'inc/block', get_row_layout(), array( 'i' => $i ) );
				}
			}

        ?>

        
            <div class="pb widget-container">
                
                    <h2>Catalog Search with Multiple Options</h2>
                    <iframe id="iframe_htCatalogSearch01" style="border: 0; margin: 0 3px; overflow: hidden" width="451" height="91"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_multi/?referrer=" + window.location.hostname;document.getElementById("iframe_htCatalogSearch01").contentWindow.document.location.href = ht_url;</script>
                    <form>
                        <div>
                            <label for="widgetcode_01">Copy Code Snippet:</label>
                            <input type="text" id="widgetcode_01" style="font-family:monospace;" value='<iframe id="iframe_htCatalogSearch01" style="border: 0; margin: 0 3px; overflow: hidden" width="451" height="91"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_multi/?referrer=" + window.location.hostname;document.getElementById("iframe_htCatalogSearch01").contentWindow.document.location.href = ht_url;</script>'>
                        </div>
                    </form>
              
            </div>
       
            <div class="pb widget-container">
                <h2>Catalog Search</h2>
                <iframe id="iframe_htCatalogSearch02" style="border: 0; margin: 0 3px; overflow: hidden" width="294" height="26"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = 'https://www.hathitrust.org/searchbox_catalog/?referrer=' + window.location.hostname;document.getElementById('iframe_htCatalogSearch02').contentWindow.document.location.href = ht_url;</script>
                <form>
                    <div>
                        <label for="widgetcode_02">Copy Code Snippet:</label>
                        <input type="text" id="widgetcode_02" style="font-family:monospace;" value='<iframe id="iframe_htCatalogSearch02" style="border: 0; margin: 0 3px; overflow: hidden" width="294" height="26"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_catalog/?referrer=" + window.location.hostname;document.getElementById("iframe_htCatalogSearch02").contentWindow.document.location.href = ht_url;</script>'>
                    </div>
                </form>
            </div>

            <div class="pb widget-container">
                <h2>Catalog Search with Full View Option</h2>
                <iframe id="iframe_htCatalogSearch03" style="border: 0; margin: 0 3px; overflow: hidden" width="300" height="63" ><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = 'https://www.hathitrust.org/searchbox_catalog_fv/?referrer=' + window.location.hostname;document.getElementById('iframe_htCatalogSearch03').contentWindow.document.location.href = ht_url;</script>
                <form>
                    <div>
                        <label for="widgetcode_03">Copy Code Snippet:</label>
                        <input type="text" id="widgetcode_03" style="font-family:monospace;" value='<iframe id="iframe_htCatalogSearch03" style="border: 0; margin: 0 3px; overflow: hidden" width="300" height="63" ><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_catalog_fv/?referrer=" + window.location.hostname;document.getElementById("iframe_htCatalogSearch03").contentWindow.document.location.href = ht_url;</script>'>
                    </div>
                </form>
            </div>

            <div class="pb widget-container">
                <h2>Full Text Search</h2>
                <iframe id="iframe_htFullTextSearch01" style="border: 0; margin: 0 3px; overflow: hidden" width="294" height="26"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = 'https://www.hathitrust.org/searchbox_fulltext/?referrer=' + window.location.hostname;document.getElementById('iframe_htFullTextSearch01').contentWindow.document.location.href = ht_url;</script>
                <form>
                    <div>
                        <label for="widgetcode_04">Copy Code Snippet:</label>
                        <input type="text" id="widgetcode_04" style="font-family:monospace;" value='<iframe id="iframe_htFullTextSearch01" style="border: 0; margin: 0 3px; overflow: hidden" width="294" height="26"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_fulltext/?referrer=" + window.location.hostname;document.getElementById("iframe_htFullTextSearch01").contentWindow.document.location.href = ht_url;</script>'>
                    </div>
                </form>
            </div>

            <div class="pb widget-container">
                <h2>Full Text Search with Full View Option</h2>
                <iframe id="iframe_htFullTextSearch02" style="border: 0; margin: 0 3px; overflow: hidden" width="300" height="63"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = 'https://www.hathitrust.org/searchbox_fulltext_fv/?referrer=' + window.location.hostname;document.getElementById('iframe_htFullTextSearch02').contentWindow.document.location.href = ht_url;</script>
                <form>
                    <div>
                        <label for="widgetcode_05">Copy Code Snippet:</label>
                        <input type="text" id="widgetcode_05" style="font-family:monospace;" value='<iframe id="iframe_htFullTextSearch02" style="border: 0; margin: 0 3px; overflow: hidden" width="300" height="63"><a href="https://catalog.hathitrust.org">Search the HathiTrust Digital Library Catalog</a></iframe><script type="text/javascript">var ht_url = "https://www.hathitrust.org/searchbox_fulltext_fv/?referrer=" + window.location.hostname;document.getElementById("iframe_htFullTextSearch02").contentWindow.document.location.href = ht_url;</script>'>
                    </div>
                </form>
            </div>
        
            
        </div>
	</div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>


