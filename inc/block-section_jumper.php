<form class="sj" hidden>
	<label for="sj">Jump to Section</label>
	<select id="sj">
<?php

	while ( have_rows( 'sections' ) ) { the_row();

?>
		<option value="<?= esc_html( get_sub_field( 'id' ) ); ?>"><?= esc_html( get_sub_field( 'label' ) ); ?></option>

<?php

	}

?>
	</select>
	<button type="submit" class="btn btn-secondary">Select</button>
</form>
