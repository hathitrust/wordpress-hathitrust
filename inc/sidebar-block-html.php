<?php

	if ( is_404() ) {
		$html = get_field( '404_content', 'options' );
	} else {
		$html = get_sub_field( 'html' );
	}

?>
<div class="sidehtml"><?= $html; ?></div>
