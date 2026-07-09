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
                <p>Drag one or more <code>.tsv</code> (tab-separated values) holdings files to this <i>drop zone</i>, or select them using the button below. The tool will check each file for errors and report the results.</p>
                <button type="button" class="btn btn-primary" id="file-button">Select files</button>
                <input type="file" id="file-input" class="file-input" multiple accept=".tsv" aria-hidden="true" tabindex="-1">
            </div>

            <div id="output" class="checker-output" style="display:none" tabindex="-1" aria-label="Results" aria-live="polite"></div>

            <section id="history-section" class="checker-history" aria-label="Check history" style="display:none">
                <div class="checker-history-header">
                    <h2>History</h2>
                    <button type="button" class="btn btn-tertiary" id="clear-history-button">Clear history</button>
                </div>
                <p class="checker-history-note">Stored only in your browser, never sent anywhere.</p>
                <ul id="history-list"></ul>
            </section>

            <section class="checker-instructions" aria-label="File format requirements">
                <h2>File format requirements</h2>

                <h3>Filename</h3>
                <p><code>&lt;member_id&gt;_&lt;type&gt;_full_&lt;YYYYMMDD&gt;.tsv</code></p>
                <p>where <code>type</code> is one of <code>spm</code>, <code>mpm</code>, <code>ser</code>, <code>mon</code>, or <code>mix</code>, and <code>YYYYMMDD</code> is the submission date.</p>
                <p>Example: <code>umich_spm_full_20241015.tsv</code></p>

                <h3>Allowed values</h3>
                <ul>
                    <li><strong>status</strong>: <code>CH</code>, <code>LM</code>, <code>WD</code>, or empty</li>
                    <li><strong>condition</strong>: <code>BRT</code> or empty</li>
                    <li><strong>govdoc</strong>: <code>1</code>, <code>0</code>, or empty</li>
                    <li><strong>oclc</strong>: Digits only, or prefixed (e.g. <code>ocn12345</code> or <code>(OCoLC)12345</code>). Multiple values may be separated by comma, semicolon, pipe, slash, or space.</li>
                </ul>
            </section>

        </div>
    </div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>
