<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

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
    <div class="twocol-main" id="page-content">
        <div class="mainplain">
            <?php the_content(); ?>

            <div id="drop-zone" role="region" aria-label="File drop zone">
                <p>Drag one or more files to this <i>drop zone</i>, or select them using the button below.</p>
                <button type="button" class="btn btn-primary" id="file-button">Select files</button>
                <input type="file" id="file-input" class="file-input" multiple accept=".tsv" aria-hidden="true" tabindex="-1">
            </div>

            <div id="output" class="checker-output" style="display:none" tabindex="-1" aria-label="Results"></div>

        </div>
    </div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>
