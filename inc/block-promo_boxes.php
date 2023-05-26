<div class="pbs">
<?php

	while ( have_rows( 'promo_boxes' ) ) { the_row();

		$contents	= get_sub_field( 'contents' );
		$cta		= get_sub_field( 'cta' );

?>
	<div class="pb">
		<div class="pb-contents"><?= wp_kses_post( $contents ); ?></div>
<?php

		if ( $cta['url'] && $cta['label'] ) {

?>
		<div class="pb-link">
			<a href="<?= esc_url( $cta['url'] ); ?>" class="link-arrow"><span><?= esc_html( $cta['label'] ); ?></span></a>
		</div>
<?php

		}

?>
	</div>
<?php

	}

?>
</div>
