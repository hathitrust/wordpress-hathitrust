<article class="post-card newsletter-card">
	<div class="post-details">
		<div class="post-title bold"><a href="<?= esc_url( get_permalink( $args['ID'] ) ); ?>"><?= esc_html( get_the_title( $args['ID'] ) ); ?></a></div>
		<div class="sm"><?= get_the_excerpt( $args['ID'] ); ?></div>
	</div>
</article>