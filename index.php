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
<?php

			# generally not used, but present for code injection
			the_content();

			if ( have_rows( 'main_blocks' ) ) {
				$i = 0;
				while ( have_rows( 'main_blocks' ) ) { the_row();
					$i++;
					get_template_part( 'inc/block', get_row_layout(), array( 'i' => $i ) );
				}
			}

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
