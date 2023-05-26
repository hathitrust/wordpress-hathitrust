<?php

	if ( ! isset( $content_width ) ) {
		$content_width = 700;
	}


	/*********************/
	/* FRONT-END ACTIONS */
	/*********************/

	// scipt loader tag callback function for adding script type="module" to firebird script tag
	function add_type_attribute($tag, $handle, $src) {
		// if not your script, do nothing and return original $tag
		if ( 'firebird-scripts' !== $handle ) {
			return $tag;
		}
		// change the script tag by adding type="module" and return it.
		$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		return $tag;
	}

	/**
	 *  Enqueues the global styles and scripts.
	 */
	function pg_enqueue_site_files() {

		wp_enqueue_style( 'site-fonts', get_template_directory_uri() . '/fonts.min.css', NULL, filemtime( get_template_directory() . '/fonts.css' ) );
		wp_enqueue_style( 'firebird-styles', 'https://hathitrust-firebird-common.netlify.app/assets/main.css');
		wp_enqueue_style( 'site-styles', get_template_directory_uri() . '/style.min.css', array( 'site-fonts' ), filemtime( get_template_directory() . '/style.min.css' ) );

		if ( is_front_page() ) {
			wp_enqueue_style( 'home-styles', get_template_directory_uri() . '/home.min.css', array( 'site-fonts', 'site-styles' ), filemtime( get_template_directory() . '/home.min.css' ) );
		}

		wp_enqueue_script( 'firebird-scripts', 'https://hathitrust-firebird-common.netlify.app/assets/main.js', array(), false, true);
		wp_enqueue_script( 'site-scripts', get_template_directory_uri() . '/js/scripts.min.js', NULL, filemtime( get_template_directory() . '/js/scripts.min.js' ), TRUE );
		wp_enqueue_script( 'fontawesome-scripts', 'https://kit.fontawesome.com/1c6c3b2b35.js');
		wp_enqueue_script( 'matomo-script', get_template_directory_uri() . '/js/matomo.js');

	}
	add_action( 'wp_enqueue_scripts', 'pg_enqueue_site_files' );
	add_filter( 'script_loader_tag', 'add_type_attribute', 10, 3);

	/**
	 *  Activate extended theme features.
	 */
	function pg_custom_theme_setup() {

		add_editor_style( 'fonts.min.css' );
		add_editor_style( 'editor-style.min.css' );

		add_image_size( 'person', 100, 100, TRUE );

		add_theme_support( 'html5', array( 'caption', 'script', 'style' ) );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );

		add_post_type_support( 'page', 'excerpt' );

	}
	add_action( 'after_setup_theme', 'pg_custom_theme_setup' );

	/**
	 *  Register locations for navigation. @TODO: This can be removed after header/footer integration.
	 */
	function pg_register_menus() {
		register_nav_menus( array(
			'temp'	=> 'Homepage Temporary'
		) );
	}
	add_action( 'init', 'pg_register_menus' );

	/**
	 *	Modifies the default number of search results per page.
	 */
	function pg_increase_search_results_count( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {
			if ( $query->is_search ) {
				$query->set( 'posts_per_page', 20 );
			}
		}
	}
	add_action( 'pre_get_posts', 'pg_increase_search_results_count' );

	/*********************/
	/* BACK-END ACTIONS */
	/*********************/

	/**
	 *  Disable unused default WordPress features.
	 */
	function pg_remove_comments() {
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'page', 'comments' );
	}
	add_action( 'init', 'pg_remove_comments' );

	/**
	 *  Suppresses unused default WordPress pages from the admin menu.
	 */
	function pg_remove_menus() {

		global $submenu;

		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );

	}
	add_action( 'admin_menu', 'pg_remove_menus' );

	/**
	 *  Suppresses unused default WordPress pages from the admin bar.
	 */
	function pg_remove_nodes( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'new-post' );
		$wp_admin_bar->remove_node( 'comments' );
	}
	add_action( 'admin_bar_menu', 'pg_remove_nodes', 999 );


	/*********************/
	/* FRONT-END FILTERS */
	/*********************/

	/**
	 *	Adds additional legal tags to wp_kses().
	 */
	function pg_add_additional_tags_to_wpkses( $tags, $context ) {

		if ( 'post' === $context ) {
			$tags['iframe'] = array(
				'allow'				=> TRUE,
				'allowfullscreen'	=> TRUE,
				'frameborder'		=> TRUE,
				'height'			=> TRUE,
				'loading'			=> TRUE,
				'src'				=> TRUE,
				'width'				=> TRUE,
			);
		}

		return $tags;
	}

	add_filter( 'wp_kses_allowed_html', 'pg_add_additional_tags_to_wpkses', 10, 2 );


	/********************/
	/* BACK-END FILTERS */
	/********************/

	/**
	 *  Suppresses unused default WordPress post list columns.
	 */
	function pg_set_edit_columns( $columns ) {
		unset( $columns['author'] );
		unset( $columns['comments'] );
		unset( $columns['posts'] );
		return $columns;
	}
	add_filter( 'manage_media_columns', 'pg_set_edit_columns' );
	add_filter( 'manage_pages_columns', 'pg_set_edit_columns' );
	add_filter( 'manage_users_columns', 'pg_set_edit_columns' );

	/**
	 *  Remove unused buttons from TinyMCE row 1.
	 */
	function pg_tinymce1( $buttons ) {
		return array_diff( $buttons, array( 'aligncenter', 'alignleft', 'alignright', 'blockquote', 'wp_more' ) );
	}
	add_filter( 'mce_buttons', 'pg_tinymce1' );

	/**
	 *  Remove unused buttons from TinyMCE row 2.
	 */
	function pg_tinymce2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return array_diff( $buttons, array( 'forecolor', 'outdent', 'indent' ) );
	}
	add_filter( 'mce_buttons_2', 'pg_tinymce2' );

	/**
	 *  TinyMCE configuration.
	 */
	function pg_editor_styles( $settings ) {

		// updates the block formats dropdown
		$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3';

		// populates formats dropdown with theme-specific values
		$style_formats = array(
			array( 'title' => 'Button (Primary)', 'selector' => 'a', 'classes' => 'btn btn-primary' ),
			array( 'title' => 'Button (Secondary)', 'selector' => 'a', 'classes' => 'btn btn-secondary' ),
			array( 'title' => 'Button (Tertiary)', 'selector' => 'a', 'classes' => 'btn btn-tertiary' ),
			array( 'title' => 'Button with Arrow', 'selector' => 'a', 'classes' => 'btn-arrow' ),
			array( 'title' => 'Button with Info', 'selector' => 'a', 'classes' => 'btn-info' ),
			array( 'title' => 'Button with PDF', 'selector' => 'a', 'classes' => 'btn-pdf' ),
			array( 'title' => 'Button with Quote', 'selector' => 'a', 'classes' => 'btn-quote' ),
			array( 'title' => 'Link with Arrow', 'selector' => 'a', 'classes' => 'link-arrow' ),
			array( 'title' => 'Spaced List', 'selector' => 'ol,ul', 'classes' => 'spacedlist' )
		);
		$settings['style_formats'] = json_encode( $style_formats );

		// cache invalidation for included stylesheets
		$settings['cache_suffix'] = '?v=' . max( array( filemtime( get_template_directory() . '/editor-style.min.css' ), filemtime( get_template_directory() . '/fonts.min.css' ) ) );

		return $settings;

	}
	add_filter( 'tiny_mce_before_init', 'pg_editor_styles' );


	/********************/
	/* PLUGIN SETTINGS */
	/*******************/

	/**
	 *  Hides the ACF "Custom Fields" menu (/wp-admin/edit.php?post_type=acf-field-group).
	 */
	#add_filter( 'acf/settings/show_admin', '__return_false' );

	/**
	 *  Registers the parent ACF options page.
	 */
	function pg_acf_options_page() {
		acf_add_options_page( array( 'page_title' => 'Site Settings', 'redirect' => FALSE ) );
	}
	add_action( 'acf/init', 'pg_acf_options_page', 97 );


	/**
	 *  Populate ACF "Navigation Menus" select field with Menus.
	 */
	function pg_acf_populate_select_with_menus( $field ) {

		$menus = get_terms( array(
			'hide_empty'	=> FALSE,
			'taxonomy'		=> 'nav_menu'
		) );

		if ( $menus ) {

			// clear out existing values if there are menus saved
			$field['choices'] = [];

			foreach ( $menus as $menuObj ) {
				$field['choices'][ $menuObj->slug ] = $menuObj->name;
			}

		}

		return $field;

	}
	add_filter( 'acf/load_field/name=menu', 'pg_acf_populate_select_with_menus' );


	/***************************/
	/* CUSTOM POSTS/TAXONOMIES */
	/***************************/

	/**
	 *  Set up custom post types.
	 */
	function pg_custom_post_types() {

		register_post_type( 'blogs',
			array(
				'label'			=> 'Blog',
				'menu_position'	=> 32,
				'menu_icon'		=> 'dashicons-admin-post',
				'public'		=> TRUE,
				'supports'		=> array( 'title', 'editor', 'excerpt' )
			)
		);

		register_post_type( 'events',
			array(
				'label'			=> 'Events',
				'menu_position'	=> 32,
				'menu_icon'		=> 'dashicons-admin-post',
				'public'		=> TRUE,
				'rewrite'		=> array(
					'slug'			=> 'event-post'
				),
				'supports'		=> array( 'title', 'editor', 'excerpt' )
			)
		);

		register_post_type( 'press',
			array(
				'label'			=> 'Press',
				'menu_position'	=> 32,
				'menu_icon'		=> 'dashicons-admin-post',
				'public'		=> TRUE,
				'rewrite'		=> array(
					'slug'			=> 'press-post'
				),
				'supports'		=> array( 'title', 'editor', 'excerpt' )
			)
		);

		register_post_type( 'newsletters',
			array(
				'label'			=> 'Newsletters',
				'menu_position'	=> 32,
				'menu_icon'		=> 'dashicons-admin-post',
				'public'		=> TRUE,
				'rewrite'		=> array(
					'slug'			=> 'newsletter-post'
				),
				'supports'		=> array( 'title', 'excerpt' )
			)
		);

	}
	add_action( 'init', 'pg_custom_post_types' );

	/**
	 *  Set up custom taxonomies.
	 */
	function pg_custom_taxonomies() {

		register_taxonomy( 'categories',
			array( 'blogs' ),
			array(
				'label'					=> 'Blog Categories',
				'meta_box_cb'			=> FALSE,
				'public'				=> FALSE,
				'publicly_queryable'	=> TRUE,
				'show_admin_column'		=> TRUE,
				'show_in_menu'			=> TRUE,
				'show_ui'				=> TRUE
			)
		);

		register_taxonomy( 'tags',
			array( 'blogs' ),
			array(
				'label'					=> 'Blog Tags',
				'meta_box_cb'			=> FALSE,
				'public'				=> FALSE,
				'publicly_queryable'	=> TRUE,
				'show_admin_column'		=> TRUE,
				'show_in_menu'			=> TRUE,
				'show_ui'				=> TRUE
			)
		);

	}
	add_action( 'init', 'pg_custom_taxonomies' );


	/********************/
	/* THEME SHORTCODES */
	/********************/

	/**
	 *  Creates a [year] shortcode.
	 *
	 *  @return	string	Current year.
	 */
	function pg_year_shortcode() {
		return date( 'Y' );
	}
	add_shortcode( 'year', 'pg_year_shortcode' );

	/*****************/
	/* HT DEV CUSTOM */
	/*****************/	

	//format bytes to mb/kb
	function formatBytes($size, $precision = 2) {
		$base = log($size, 1024);
		$suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

		return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}

	// my attempt to write a hathifiles directory listing with php
	function hathifiles() {
		
		$directory = "/htapps/test.www/files/hathifiles";
		$files = new \FileSystemIterator($directory);

		$html = [];
		class HTfile {
			public $fileName;
			public $filePath;
			public $lastModified;
			public $fileSize;
			public $fileInfo;
		}
		foreach ($files as $file) {
			$hathifile = new HTfile();
			if (! $files->isDir() )
		
			$hathifile->fileName = $files->getFileName();
			$hathifile->filePath = $files->getPathName();
			$hathifile->lastModified = $files->getMTime();
			$hathifile->fileSize = formatBytes($files->getSize());
			$hathifile->fileInfo = $files->getFileInfo();

			$html[] = $hathifile;

		}

		//sort array by last modified, starting with newest
		usort($html, function($a, $b) {
			return ($b->lastModified) - ($a->lastModified);
		});

		foreach ($html as $key => $value) {
			echo "$value->filePath";
			echo "<tr><td><a href='https://www.hathitrust.org/sites/www.hathitrust.org/files/hathifiles/".$value->fileName."'>".$value->fileName."</a></td><td>".date('M d, Y', $value->lastModified)."</td><td>".$value->fileSize."</td></tr>";
		}
	}

	