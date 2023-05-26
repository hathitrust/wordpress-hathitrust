<?php

	$img	= get_field( 'thumbnail_image', $args['ID'] );
	$cat	= get_the_terms( $args['ID'], 'categories' );

?>
<article class="post-card blog-card">
	<div class="post-img">
		<a href="<?= esc_url( get_permalink( $args['ID'] ) ); ?>" aria-hidden="true" tabindex="-1">
<?php

	if ( ! $img ) {
		if ( isset( $args['isPostEmbed'] ) && $args['isPostEmbed'] ) {
			$defaultImgs = get_field( 'default_newsletter_images', 'options' );
			$img = $defaultImgs['blog'];
		} else {
			$img = get_field( 'default_blog_image', 'options' );
		}
	}

	echo wp_get_attachment_image( $img, 'full', FALSE, array( 'alt' => '' ) );

?>
		</a>
	</div>
	<div class="post-details">
<?php

	if ( is_array( $cat ) ) {

?>
		<div class="post-cat"><?= esc_html( $cat[0]->name ); ?></div>
<?php

	}

?>
		<div class="post-title bold"><a href="<?= esc_url( get_permalink( $args['ID'] ) ); ?>"><?= esc_html( get_the_title( $args['ID'] ) ); ?></a></div>
		<div class="sm"><?= get_the_excerpt( $args['ID'] ); ?></div>
		<div class="sm"><?= get_the_date( get_option( 'date_format' ), $args['ID'] ); ?></div>
	</div>
</article>