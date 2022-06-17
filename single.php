<?php

/**
 * The Template for displaying all single posts.
 */

get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();

		get_template_part('content', 'single');

	endwhile;
endif;

wp_reset_postdata(); //  loop.

get_footer();
