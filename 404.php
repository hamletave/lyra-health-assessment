<?php

/**
 * Template Name: Not found
 * Description: Page template 404 Not found
 *
 */

get_header();
?>
<div id="post-0" class="content error404 not-found">
	<h1 class="entry-title"><?php esc_html_e('Not found', 'lyra-assessment'); ?></h1>
	<div class="entry-content">
		<p><?php esc_html_e('It looks like nothing was found at this location.', 'lyra-assessment'); ?></p>
	</div><!-- /.entry-content -->
</div><!-- /#post-0 -->
<?php
get_footer();
