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
		<div>
		<h1><?= wp_kses_post( $title ); ?></h1>
<?php

			$blogCats = get_the_terms( get_the_ID(), 'categories' );
			if ( $blogCats ) {

?>
			<p class="has-hl">
<?php

				foreach ( $blogCats as $blogCat ) {

?>
			<a href="<?= add_query_arg( array( 'categories' => $blogCat->slug ), get_permalink( get_page_by_path( 'blog' ) ) ); ?>"><?= esc_html( $blogCat->name ); ?></a>
<?php

				}

?>
			</p>
<?php

			}

?>
			<p><?= get_the_date( get_option( 'date_format' ) ); ?></p>
		</div>
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
			<!-- <p><?= get_the_date( get_option( 'date_format' ) ); ?></p> -->
<?php

			the_content();

?>
		</div>
<?php

			$globalPromoBox = get_field( 'global_promo_box', 'options' );
			if ( $globalPromoBox['enabled'] && ! get_field( 'disable_global_promo_box' ) ) {
				get_template_part( 'inc/block', 'promo_box', $globalPromoBox );
			}

?>
	</div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>
