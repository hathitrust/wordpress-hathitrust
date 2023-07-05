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
	<div class="twocol-main">
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
            <div class="btable-wrapper">
                <?php
                  echo do_shortcode('[m1dll path="sites/www.hathitrust.org/files/ingest_logs"
                    label="Ingest Logs" filetime="M d, Y" foldertime="M d, Y"]');
                ?>
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


