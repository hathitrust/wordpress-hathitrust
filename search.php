<?php

	get_header();

?>
<div class="twocol">
	<div class="twocol-side">
		<h1>Search Results</h1>
	</div>
	<div class="twocol-main">
<?php

	global $wp_query;

	if ( $wp_query->found_posts ) {

    $thisPage		= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $firstResult	= ( ( $thisPage - 1 ) * 20 ) + 1;
    $lastResult		= ( $thisPage * 20 ) > $wp_query->found_posts ? $wp_query->found_posts : ( $thisPage * 20 );

		$resultsStr = $firstResult . ' to ' . $lastResult . ' of ' . $wp_query->found_posts . ' ' . ngettext( 'result', 'results', $wp_query->found_posts );

	} else {
		$resultsStr = '0 results';
	}


?>
		<div class="search-head">
			<p>Search results for “<?= esc_html( get_search_query() ); ?>”</p>
			<p><?= $resultsStr; ?></p>
		</div>
<?php

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

?>
		<article class="search-card pb">
			<a href="<?= esc_url( get_permalink() ); ?>"><?= esc_html( get_the_title() ); ?></a>
			<div><?= get_the_excerpt(); ?></div>
		</article>
<?php

		}

?>
		<div class="pagination">
<?php

		$paginationArgs = [];

		echo paginate_links( array(
			'add_args'	=> $paginationArgs,
			'current'	=> max( 1, get_query_var( 'paged' ) ),
			'end_size'	=> 1,
			'mid_size'	=> 1,
			'next_text'	=> file_get_contents( get_stylesheet_directory() . '/inc/arrow-next.svg' ) . '<span class="screen-reader-text">Next</span>',
			'prev_text'	=> file_get_contents( get_stylesheet_directory() . '/inc/arrow-prev.svg' ) . '<span class="screen-reader-text">Previous</span>',
			'total'		=> $wp_query->max_num_pages
		) );

?>
		</div>
<?php

	} else {
		?> <p>Your search returned 0 results. Please try a new search.</p> <?php
	}

?>
	</div>
</div>
<?php

	get_template_part( 'inc/backtotop' );

	get_footer();

?>
