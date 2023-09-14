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
			
			
			   <?php 
				// if the post/page has no excerpt, get_the_excerpt returns an empty string and thus an empty div
				// so check that the exceprt exists	   
				if(get_the_excerpt() ) { 
				
				?>
			   
				<div><?= the_excerpt(); ?></div>
				<?php 
			    }  
			
				// if there's no excerpt, check the ACF fields for the first "content" block and give me the first 250 words with an ellipses at the end
				if ( have_rows( 'main_blocks' ) ){
					$i = 0;
					while ( have_rows( 'main_blocks' ) ){ the_row();
						
						if (get_row_layout() == 'content' && $i == 0) {
							$i++;	
								//$format_value = false gets rid of the paragraph formatting so the excerpt matches the other excerpt formatting
								$text = wp_kses_post( get_sub_field( 'content' , $format_value = false) ); 	
								if (strlen($text) > 250) {
									$truncated_text = substr($text, 0, 250);
									$last_space = strrpos($truncated_text, " ");
									$truncated_text = substr($truncated_text, 0, $last_space);
									$truncated_text .= "...";
									
									$content_excerpt = $truncated_text;
								} else {
									$content_excerpt = $text;
								}


								
							?><div><?= $content_excerpt; ?></div>
							
							<?php
						
						}
					}
				}
				?>
				
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
