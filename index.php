<?php

/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

get_header();
?>
<div class="row">
	<div class="col-md-12">
		<?php
		get_template_part('archive', 'loop');
		?>
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
get_footer();
