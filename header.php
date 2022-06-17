<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="sr-only sr-only-focusable"><?php esc_html_e('Skip to main content', 'lyra-assessment'); ?></a>

	<div id="wrapper">
		<header>
			<nav id="header" class="navbar navbar-expand-md <?php echo esc_attr($navbar_scheme);
															if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' fixed-top';
															elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' fixed-bottom';
															endif;
															if (is_home() || is_front_page()) : echo ' home';
															endif; ?>">
				<div class="container">
					<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php
						$header_logo = get_theme_mod('header_logo'); // Get custom meta-value.

						if (!empty($header_logo)) :
						?>
							<img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
						<?php
						else :
							echo esc_attr(get_bloginfo('name', 'display'));
						endif;
						?>
					</a>
				</div><!-- /.container -->
			</nav><!-- /#header -->
		</header>

		<main id="main" class="container" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
											elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
											endif; ?>>
			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>
				<div class="row">
					<div class="col-md-8 col-sm-12">
					<?php
				endif;
					?>