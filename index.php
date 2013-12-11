<?php 
get_header();
?>

<header id="begin">
	<time datetime="<?php echo date('Y-m-d'); ?>" id="top_time"><?php echo date('F d, Y'); ?></time>
</header>

<?php
get_template_part( 'loop', 'index' );
?>

<?php
get_footer(); 
