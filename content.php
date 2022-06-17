<?php

/**
 * The default template for displaying content
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if (is_sticky()) :
		?>
			<hgroup>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'lyra-assessment'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<h3 class="entry-format"><?php _e('Featured', 'lyra-assessment'); ?></h3>
			</hgroup>
		<?php
		else :
		?>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'lyra-assessment'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		<?php
		endif;
		?>
	</header><!-- /.entry-header -->


	<div class="entry-content">
		<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'lyra-assessment')); ?>
		<?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'lyra-assessment') . '</span>', 'after' => '</div>')); ?>
	</div><!-- /.entry-content -->


	<footer class="entry-meta">
		<?php
		$show_sep = false;
		if ('post' === get_post_type()) :

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(__(', ', 'lyra-assessment'));
			if ($categories_list) :
		?>
				<span class="cat-links">
					<?php printf(__('<span class="%1$s">Posted in</span> %2$s', 'lyra-assessment'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list);
					$show_sep = true; ?>
				</span>
				<?php
			endif; // End if $categories_list.

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', __(', ', 'lyra-assessment'));
			if ($tags_list) :
				if ($show_sep) :
				?>
					<span class="sep"> | </span>
				<?php
				endif; // End if $show_sep.
				?>
				<span class="tag-links">
					<?php
					printf(__('<span class="%1$s">Tagged</span> %2$s', 'lyra-assessment'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
					$show_sep = true;
					?>
				</span>
		<?php
			endif; // End if $tags_list.
		endif;

		?>

		<a href="<?php echo get_the_permalink(); ?>" class="btn btn-secondary"><?php esc_html_e('more', 'lyra-assessment'); ?></a>

		<?php edit_post_link(__('Edit', 'lyra-assessment'), '<span class="edit-link">', '</span>'); ?>
	</footer><!-- /.entry-meta -->
</article><!-- /#post-<?php the_ID(); ?> -->