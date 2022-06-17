<?php

/**
 * Template Name: Events
 */

get_header();
?>

<div class="row">
	<?php
	$the_query = new WP_Query(array(
		'post_type' => 'event',
		'orderby' => 'publish_date',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'event_type',
				'field' => 'slug',
				'terms' => 'webinar',
			)
		),
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'compare' => '>',
				'value' => '2020-01-02',
				'type' => 'DATE',
			)
		),
	));

	while ($the_query->have_posts()) :
		$the_query->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
			<div class="card mb-5">
				<?php
				if (has_post_thumbnail()) :
					echo '<div class="post-thumbnail m-0">' . get_the_post_thumbnail(get_the_ID(), 'large') . '</div>';
				endif;
				?>
				<div class="card-body">
					<h3 class="card-title">
						<?php the_title(); ?>
					</h3>
					<div class="card-text entry-content">
						<?php the_excerpt(); ?>
					</div>
					<footer class="entry-meta">
						<a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e('Read More', 'lyra-assessment'); ?></a>
					</footer>
				</div>
			</div>
		</article>

	<?php endwhile;
	wp_reset_postdata();
	?>
</div>

<?php
get_footer();
