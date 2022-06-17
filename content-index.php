<?php

/**
 * The template for displaying content in the index.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
	<div class="card mb-5">
		<div class="card-body">
			<h2 class="card-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'lyra-assessment'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<div class="card-text entry-content">
				<?php
				if (has_post_thumbnail()) :
					echo '<div class="post-thumbnail">' . get_the_post_thumbnail(get_the_ID(), 'large') . '</div>';
				endif;

				the_content();

				?>
				<?php wp_link_pages(array('before' => '<div class="page-link"><span>' . esc_html__('Pages:', 'lyra-assessment') . '</span>', 'after' => '</div>')); ?>
			</div><!-- /.card-text -->
			<footer class="entry-meta">
				<a href="<?php echo get_the_permalink(); ?>" class="btn btn-outline-secondary"><?php esc_html_e('Read More', 'lyra-assessment'); ?></a>
			</footer><!-- /.entry-meta -->
		</div><!-- /.card-body -->
	</div><!-- /.col -->
</article><!-- /#post-<?php the_ID(); ?> -->