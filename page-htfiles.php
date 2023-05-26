<?php

	get_header();

?>
<div class="twocol">
	<div class="twocol-side">
		<h1>Custom Hathifiles</h1>
	</div>
	<div class="twocol-main">
<?php

		// get_file_links('downloads');
        ?>
        <table class="table">
            <tr>
                <th>File</th>
                <th>Date</th>
                <th>File size</th>
            </tr>
           <?php hathifiles(); ?> 
        </table>

	</div>
</div>
<?php


	get_footer();

?>