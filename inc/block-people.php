<div class="people">
<?php

	while ( have_rows( 'people' ) ) { the_row();

		$name = esc_html( get_sub_field( 'name' ) );

?>
	<div class="person">
		<?= wp_get_attachment_image( get_sub_field( 'photo' ), 'person', FALSE, array( 'class' => 'person-img' ) ); ?>
		<div class="person-head">
			<div class="h3"><?= $name; ?></div>
			<div><?= esc_html( get_sub_field( 'title' ) ); ?></div>
<?php

		$linkedin	= get_sub_field( 'linkedin' );
		$email		= get_sub_field( 'email' );
		$twitter	= get_sub_field( 'twitter' );

		if ( $linkedin || $email || $twitter ) {

?>
			<ul class="semlist">
<?php

			if ( $linkedin ) {

?>
				<li>
					<a href="<?= esc_url( $linkedin ); ?>">
						<svg width="15" height="20" aria-hidden="true"><use href="#person-linkedin"></svg>
						<span class="screen-reader-text"><?= $name; ?> on LinkedIn</span>
					</a>
				</li>
<?php

			}

			if ( $email ) {

?>
				<li>
					<a href="<?= esc_url( 'mailto:' . $email ); ?>">
						<svg width="17" height="18" aria-hidden="true"><use href="#person-email"></svg>
						<span class="screen-reader-text">Email <?= $name; ?></span>
					</a>
				</li>
<?php

			}

			if ( $twitter ) {

?>
				<li>
					<a href="<?= esc_url( 'https://twitter.com/' . $twitter ); ?>">
						<svg width="17" height="20" aria-hidden="true"><use href="#person-twitter"></svg>
						<span class="screen-reader-text"><?= $name; ?> on Twitter</span>
					</a>
				</li>
<?php

			}

?>
			</ul>
<?php

		}

?>
		</div>
		<div class="person-bio"><?= wp_kses_post( get_sub_field( 'bio' ) ); ?></div>
	</div>
<?php

	}

?>
</div>
<?php

	require_once __DIR__ . '/person.svg';

?>