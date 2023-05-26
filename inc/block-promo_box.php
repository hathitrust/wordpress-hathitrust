<?php

	if ( isset( $args['enabled'] ) && $args['enabled'] ) { # called by the Global Promo Box
		$el			= 'div';
		$heading	= $args['heading'];
		$h2			= '<h2 class="pb-heading allcaps">' . esc_html( $heading ) . '</h2>';
		$contents	= $args['contents'];
		$cta		= $args['cta'];
	} elseif ( isset( $args['sidebar'] ) && $args['sidebar'] ) { # called by sidebar-block_promo_box
		$el			= 'aside';
		$heading	= get_sub_field( 'heading' );
		$h2			= '<h2 class="pb-heading allcaps">' . esc_html( $heading ) . '</h2>';
		$contents	= get_sub_field( 'contents' );
		$cta		= get_sub_field( 'cta' );
	} else {
		$el			= 'div';
		$heading	= get_sub_field( 'heading' );
		$h2			= '<h2 id="' . sanitize_title_with_dashes( $heading ) . '" class="pb-heading allcaps">' . esc_html( $heading ) . '</h2>';
		$contents	= get_sub_field( 'contents' );
		$cta		= get_sub_field( 'cta' );
	}

?>
<<?= $el; ?> class="pb-wrapper">
	<?= $h2; ?>
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
</<?= $el; ?>>
