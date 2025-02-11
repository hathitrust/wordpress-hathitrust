<?php

	$table = get_sub_field( 'table' );

	$rowHeaders = get_sub_field( 'row_headers' );

	if ( ! empty( $table ) ) {

		$tableClass = 'btable';
		if ( $rowHeaders ) {
			$tableClass = 'btable btable-hasrowheaders';
		}

?>
<div class="btable-wrapper">
	<table class="<?= $tableClass; ?>" data-labelid="<?= esc_attr( 'caption' . $args['i'] ); ?>">
		<caption id="<?= esc_attr( 'caption' . $args['i'] ); ?>" class="screen-reader-text"><?= esc_html( get_sub_field( 'label' ) ); ?></caption>
<?php

			if ( ! empty( $table['header'] ) ) {

?>
		<thead>
			<tr>
<?php

						foreach ( $table['header'] as $th ) {

							if ( $th['c'] ) {

?>
				<th><?= esc_html( $th['c'] ); ?></th>
<?php

							} else {

?>
				<td></td>
<?php
							}

						}

?>
			</tr>
		</thead>
<?php
			}

?>
		<tbody>
<?php

				foreach ( $table['body'] as $tr ) {

?>
			<tr>
<?php

						foreach ( $tr as $key => $td ) {

							$el = 'td';
							if ( $rowHeaders && $key === 0 ) {
								$el = 'th';
							}

?>
				<<?= $el; ?>><?= wp_kses_post( $td['c'] ); ?></<?= $el; ?>>
<?php

						}

?>
			</tr>
<?php

				}

?>
		</tbody>
	</table>
</div>
<?php

	}

?>
