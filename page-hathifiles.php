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
                <table class="btable">
                    <thead>
                    <tr>
                        <th>File</th>
                        <th>Date</th>
                        <th>File size</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //takes $directory and $linkpath variables and creates table rows 
                        file_list("/htapps/www/files/hathifiles", "https://www.hathitrust.org/files/hathifiles/" ); ?>
                    </tbody>
                </table>
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


