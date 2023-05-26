<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

			get_template_part( 'inc/breadcrumbs' );

			$override = get_field( 'title_override' );
			$title = $override ? $override : get_the_title();

?>
<div class="twocol">
	<div class="twocol-side">
		<h1><?= wp_kses_post( $title ); ?></h1>
<?php

			if ( have_rows( 'sidebar_blocks' ) ) {
				while ( have_rows( 'sidebar_blocks' ) ) { the_row();
					get_template_part( 'inc/sidebar-block', get_row_layout() );
				}
			}

?>
	</div>
	<div class="twocol-main">
		<div class="post-cards press-cards">
<?php

			$args = [];
			
			$args['post_type']	= 'press';
			$args['paged']		= get_query_var( 'paged' );

			$loop = new WP_Query( $args );

			if ( $loop->have_posts() ) {

				while ( $loop->have_posts() ) { $loop->the_post();
					get_template_part( 'inc/card', 'press', array( 'ID' => get_the_ID() ) );
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
					'total'		=> $loop->max_num_pages
				) );

?>
			</div>
<?php

			} else {

?>
				<p>No press posts found.</p>
<?php

			}

			wp_reset_postdata();

?>
		</div>
	</div>
</div>
<?php

		}

		#get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>
