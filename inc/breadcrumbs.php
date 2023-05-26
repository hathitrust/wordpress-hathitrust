<nav class="bc has-hl" aria-label="Breadcrumbs">
	<ol itemscope itemtype="https://schema.org/BreadcrumbList" class="semlist">
		<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a itemprop="item" href="<?= esc_url( get_home_url() ); ?>">
				<span itemprop="name">Home</span>
			</a>
			<meta itemprop="position" content="1">
		</li>
<?php

	$posCnt = 1;

	if ( is_page() ) {

		$ancestorsArr = get_post_ancestors( get_the_ID() );
		if ( is_array( $ancestorsArr ) ) {

			$ancestorsArr = array_reverse( $ancestorsArr );

			foreach ( $ancestorsArr as $postID ) {

				$posCnt++;

?>
		<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a itemprop="item" href="<?= esc_url( get_permalink( $postID ) ); ?>">
				<span itemprop="name"><?= esc_html( get_the_title( $postID ) ); ?></span>
			</a>
			<meta itemprop="position" content="<?= $posCnt; ?>">
		</li>
<?php

			}

		}

	} elseif ( is_singular() ) {

		$listPage = 0;

		if ( is_singular( 'blogs' ) ) {
			$listPage = get_page_by_path( 'blog' );
		} elseif ( is_singular( 'press' ) ) {
			$listPage = get_page_by_path( 'press' );
		} elseif ( is_singular( 'events' ) ) {
			$listPage = get_page_by_path( 'events' );
		} elseif ( is_singular( 'newsletters' ) ) {
			$listPage = get_page_by_path( 'newsletters' );
		}

		if ( $listPage ) {

			$posCnt++;

?>
		<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a itemprop="item" href="<?= esc_url( get_permalink( $listPage ) ); ?>">
				<span itemprop="name"><?= esc_html( get_the_title( $listPage ) ); ?></span>
			</a>
			<meta itemprop="position" content="<?= $posCnt; ?>">
		</li>
<?php

		}

	}

	$posCnt++;

?>
		<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a itemprop="item" href="<?= esc_url( get_permalink() ); ?>" aria-current="page">
				<span itemprop="name"><?= esc_html( get_the_title() ); ?></span>
			</a>
			<meta itemprop="position" content="<?= $posCnt; ?>">
		</li>
	</ol>
</nav>
