<?php 
if (is_front_page() ){ 
?>
<hathi-website-header></hathi-website-header>
<?php
 } else {
 ?>

<div id="ht-header">
<hathi-website-header data-prop-search-state="toggle"></hathi-website-header>
</div>

 <?php 
 }
