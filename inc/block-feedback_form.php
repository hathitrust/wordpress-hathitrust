<div class="pb-wrapper pb2-wrapper">
	<h2 id="<?= sanitize_title_with_dashes( $heading ); ?>" class="pb-heading allcaps"><?= esc_html( get_sub_field( 'heading' ) ); ?></h2>
	<div class="pb">
		<div class="pb-contents"><?= wp_kses_post( get_sub_field( 'contents' ) ); ?></div>
		<div class="pb-link" data-hathi-trigger="hathi-feedback-form-modal" id="feedback-form">
			<button type="button" class="link-arrow"><span><?= get_sub_field( 'label' ); ?></span></button>
		</div>
	</div>
	<hathi-feedback-form-modal data-prop-form="basic" data-prop-is-open="false"></hathi-feedback-form-modal">
</div>

