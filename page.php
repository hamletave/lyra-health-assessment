<?php

/**
 * Template Name: Page (Default)
 * Description: Page template
 *
 */
get_header();

the_post();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<p>This is some test text some more lorem ipsum</p>
	<?php
	the_content();

	wp_link_pages(array(
		'before' => '<div class="page-links">' . __('Pages:', 'lyra-assessment'),
		'after'  => '</div>',
	));
	edit_post_link(__('Edit', 'lyra-assessment'), '<span class="edit-link">', '</span>');
	?>
</div><!-- /#post-<?php the_ID(); ?> -->
<?php

get_footer();
