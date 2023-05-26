<?php

	wp_nav_menu(
		array(
			'container'				=> 'nav',
			'container_aria_label'	=> 'Secondary',
			'depth'					=> 3,
			'fallback_cb'			=> FALSE,
			'menu'					=> get_sub_field( 'menu' ),
			'menu_class'			=> 'sidenav semlist'
		)
	);
