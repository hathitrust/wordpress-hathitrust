<aside class="cattags">
<?php

	### BEGIN CATEGORIES LIST ###

	$terms = get_terms( array(
		'taxonomy'		=> 'categories',
		'hide_empty'	=> FALSE
	) );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {

		global $selectedCategory;
		$selectedCategory = get_query_var( 'categories', FALSE );

		$openStr = '';
		if ( $selectedCategory ) {
			$openStr = ' open';
		}

?>
	<details<?= $openStr; ?>>
		<summary class="allcaps allcaps-book">Categories</summary>
		<ul class="cattags-cats semlist">
<?php

		global $selectedCategory;
		$selectedCategory = get_query_var( 'categories', FALSE );

		foreach ( $terms as $term ) {

			$classStr = ( $selectedCategory === $term->slug ) ? ' class="active"' : '';

			$url = add_query_arg( array( 'categories' => $term->slug ), get_permalink() );

?>
			<li<?= $classStr; ?>>
				<a href="<?= esc_url( $url ); ?>"><?= esc_html( $term->name ); ?></a>
			</li>
<?php

		}

		$classStr = ! $selectedCategory ? ' class="active"' : '';

?>
			<li<?= $classStr; ?>>
				<a href="<?= esc_url( get_permalink() ); ?>">View All</a>
			</li>
		</ul>
	</details>
<?php

	}

	### END CATEGORIES LIST ###

	### BEGIN TAGS LIST ###

	/*commenting out the tags for launch (summer 2023), will re-enable when we're ready */
	/*
	$terms = get_terms( array(
		'taxonomy'		=> 'tags',
		'hide_empty'	=> FALSE
	) );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {

		global $selectedTags;
		$selectedTags = get_query_var( 'tags', FALSE );

		$openStr = '';
		if ( $selectedTags ) {
			$openStr = ' open';
		}

?>
	<details<?= $openStr; ?>>
		<summary class="allcaps allcaps-tag">Tags</summary>
		<ul class="cattags-tags semlist">
<?php

		foreach ( $terms as $term ) {

			$classStr = '';

			if ( $selectedTags ) {

				$selectedArr = explode( ',', $selectedTags );

				$classStr = in_array( $term->slug, $selectedArr ) ? ' class="active"' : '';

				# if the term is already in the query var, remove it; otherwise, add it
				$pos = array_search( $term->slug, $selectedArr );
				if ( $pos !== FALSE ) {
					unset( $selectedArr[$pos] );
				} else {
					$selectedArr[] = $term->slug;
				}

				# makes for a tidier, more-consistent URL
				sort( $selectedArr );

				$urlTermStr = implode( ',', $selectedArr );

			} else {
				$urlTermStr = $term->slug;
			}

			$urlArgs = [];

			if ( $selectedCategory ) {
				$urlArgs['categories'] = $selectedCategory;
			}
			$urlArgs['tags'] = strlen( $urlTermStr ) ? $urlTermStr : FALSE;

			$url = add_query_arg( $urlArgs, get_permalink( get_page_by_path( 'blog' ) ) );

?>
			<li<?= $classStr; ?>>
				<a href="<?= esc_url( $url ); ?>"><?= esc_html( $term->name ); ?></a>
			</li>
<?php

		}

?>
		</ul>
	</details>
<?php

	}

	*/ 
	## end of commented out tags

	### END TAGS LIST ###

?>
</aside>
