<?php

	$attribution = get_sub_field( 'attribution' );

?>
<aside class="side-testimonial">
	<h2 class="pb-heading allcaps allcaps-quote">Testimonial</h2>
	<figure class="pb">
		<blockquote class="pb-contents"><?= wp_kses_post( get_sub_field( 'quotation' ) ); ?></blockquote>
		<figcaption class="sm ital">
			<div class="bold"><?= esc_html( $attribution['line_1'] ); ?></div>
			<div><?= esc_html( $attribution['line_2'] ); ?></div>
		</figcaption>
	</figure>
</aside>
