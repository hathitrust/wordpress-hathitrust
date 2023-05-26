<?php

	$htmlClassArr = array( 'no-js' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?= esc_attr( implode( ' ', $htmlClassArr ) ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="preload" href="<?= esc_url( get_template_directory_uri() . '/fonts/mulish-v12-latin-500.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<?php

	wp_head();

?>
</head>
<body <?php body_class(); ?> tabindex="-1">
<?php

	wp_body_open();

?>
	<div id="maindocument">
<?php

	get_template_part( 'inc/client-header' );

?>
		<main id="content" class="main" tabindex="-1">
