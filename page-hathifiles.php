<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

			get_template_part( 'inc/breadcrumbs' );

			

?>
<div class="twocol">
	<div class="twocol-side">
		<h1><?= wp_kses_post( $title ); ?></h1>

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
        <table class="table">
            <tr>
                <th>File</th>
                <th>Date</th>
                <th>File size</th>
            </tr>
            <?php hathifiles(); ?>
        </table>
		</div>

	</div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>


