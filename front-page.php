<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

?>
<div class="hmain">
	<h1 class="visually-hidden">Home page</h1> 
	<section class="home-fatl">
		<h2 class="h3 allcaps">From Around the Library</h2>
		<div class="home-fatl-cards">
<?php

			$i = 0;

			while ( have_rows( 'library_items' ) ) { the_row();

				$i++;
				$itemCnt = get_sub_field( 'item_count' );

?>
			<article class="fatl-card fatl-card<?= $i; ?>">
				<a href="<?= esc_url( get_sub_field( 'url' ) ); ?>" aria-hidden="true" tabindex="-1"><?= wp_get_attachment_image( get_sub_field( 'image' ), 'full', FALSE, array( 'loading' => $i === 1 ? 'eager' : 'lazy' ) ); ?></a>
				<div class="fatl-card-content">
					<a class="fatlc-title d-inline-block" href="<?= esc_url( get_sub_field( 'url' ) ); ?>"><?= wp_kses_post( get_sub_field( 'title' ) ); ?></a>
					<div class="fatlc-excerpt"><?= wp_kses_post( get_sub_field( 'excerpt' ) ); ?></div>
<?php

				$collection = get_sub_field( 'collection' );
				if ( $collection ) {

?>
					<div class="post-cat"><?= esc_html( $collection ); ?></div>
<?php

				}

?>
				</div>
			</article>
<?php

			}


?>
		</div>
	</section>
	<section class="home-nae">
		<h2 class="h3 allcaps">News & Events</h2>
		<div class="home-nae-cards">
<?php

			while ( have_rows( 'news_and_events_posts' ) ) { the_row();

				$postID = get_sub_field( 'press_or_event' );
				$img = get_field( 'thumbnail_image', $postID );

				if ( 'press' === get_post_type( $postID ) ) {
					$excerpt = get_the_date( get_option( 'date_format' ), $postID );
				} elseif ( 'events' === get_post_type( $postID ) ) {
					$excerpt = get_the_date( get_option( 'date_format' ), $postID );
				}

?>
			<article class="nae-card">
<?php

				if ( $img ) {

?>
				<a href="#" aria-hidden="true" tabindex="-1"><?= wp_get_attachment_image( $img, 'full', FALSE, array( 'alt' => '' ) ); ?></a>
<?php

				}

?>
				<div class="nae-card-content">
					<a class="nae-title d-inline-block" href="<?= esc_url( get_permalink( $postID ) ); ?>"><?= esc_html( get_the_title( $postID ) ); ?></a>
					<div class="nae-excerpt"><?= $excerpt; ?></div>
				</div>
			</article>
<?php

			}

?>
		</div>
	</section>
	<section class="home-ftb">
		<h2 class="allcaps">
			<a href="<?= esc_url( get_permalink( get_page_by_path( 'blog' ) ) ); ?>" class="link-arrow">From the Blog</a>
		</h2>
		<div class="home-ftb-cards post-cards">
<?php

			while ( have_rows( 'blog_posts' ) ) { the_row();
				get_template_part( 'inc/card', 'blogs', array( 'ID' => get_sub_field( 'blog' ) ) );
			}

?>
		</div>
	</section>
<?php

			$about = get_field( 'about' );

?>
	<div class="home-about">
		<div class="habout-inner">
			<a href="<?= esc_url( $about['cta']['url'] ); ?>" class="allcaps link-arrow link-arrow-white"><span><?= esc_html( $about['cta']['label'] ); ?></span></a>
			<h2 class="bold"><?= esc_html( $about['headline'] ); ?></h2>
			<div class="habout-copy"><?= wp_kses_post( $about['content'] ); ?></div>
		</div>
	</div>
<?php

			// $pres = get_field( 'presentations' );
			$training = get_field( 'training' );

?>
	
	<section class="home-fc">
		<h2 class="h3 allcaps">Featured Collections</h2>
		<div class="home-fc-cards">
<?php

			$i = 0;

			while ( have_rows( 'collections' ) ) { the_row();

				$i++;
				$itemCnt = get_sub_field( 'item_count' );

?>
			<article class="fc-card fc-card<?= $i; ?>">
				<a href="<?= esc_url( get_sub_field( 'url' ) ); ?>" aria-hidden="true" tabindex="-1"><?= wp_get_attachment_image( get_sub_field( 'image' ), 'full' ); ?></a>
				<div class="fc-card-content">
					<a class="fc-title" href="<?= esc_url( get_sub_field( 'url' ) ); ?>"><?= wp_kses_post( get_sub_field( 'title' ) ); ?></a>
					<div class="fc-cnt"><?= sprintf( ngettext( '%s item', '%s items', $itemCnt ), number_format( $itemCnt ) ); ?></div>
					<div class="fc-excerpt"><?= wp_kses_post( get_sub_field( 'excerpt' ) ); ?></div>
				</div>
			</article>
<?php

			}


?>
		</div>
	</section>
	<div class="home-pres">
		<div class="yt-no-consent pres-card">
				<a href="<?= esc_url( $training['image']['url'] ); ?>" aria-hidden="true" tabindex="-1"><img src="<?= esc_url( $training['image']['med_img']['url'] ); ?>" alt=""/></a>
		</div>
		<div class="hpres-content">
			<a href="<?= esc_url( $training['cta']['url'] ); ?>" class="allcaps link-arrow"><span><?= esc_html( $training['cta']['label'] ); ?></span></a>
			<div class="hpres-copy"><?= wp_kses_post( $training['content'] ); ?></div>
		</div>
	</div>
</div>
<?php

		}

		#get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>
