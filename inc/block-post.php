<div class="post-cards embedded-post-cards">
<?php

	$postID = get_sub_field( 'post' );

	get_template_part( 'inc/card', get_post_type( $postID ), array( 'ID' => $postID, 'isPostEmbed' => TRUE ) );

?>
</div>
