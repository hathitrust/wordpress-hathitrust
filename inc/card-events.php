<article class="post-card event-card">
<?php

	$img = get_field( 'thumbnail_image', $args['ID'] );

	if ( ! $img && ( isset( $args['isPostEmbed'] ) && $args['isPostEmbed'] ) ) {
		$defaultImgs = get_field( 'default_newsletter_images', 'options' );
		$img = $defaultImgs['events'];
	}

	if ( $img ) {

?>
	<div class="post-img">
		<a href="<?= esc_url( get_permalink( $args['ID'] ) ); ?>" aria-hidden="true" tabindex="-1">
			<?= wp_get_attachment_image( $img, 'full', FALSE, array( 'alt' => '' ) ); ?>
		</a>
	</div>
<?php

	}

?>
	<div class="post-details">
		<div class="post-title bold"><a href="<?= esc_url( get_permalink( $args['ID'] ) ); ?>"><?= esc_html( get_the_title( $args['ID'] ) ); ?></a></div>
		<div class="sm"><?= get_the_excerpt( $args['ID'] ); ?></div>
		<div class="sm"><?= get_the_date( get_option( 'date_format' ), $args['ID'] ); ?></div>
	</div>
</article>