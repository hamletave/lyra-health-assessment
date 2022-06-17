<?php

/**
 * The template for displaying the archive loop
 */

if (have_posts()) :
?>
	<div class="row">
		<?php
		while (have_posts()) :
			the_post();
			get_template_part('content', 'index'); // Post format: content-index.php
		endwhile;
		?>
	</div>
<?php
endif;

wp_reset_postdata();
