<?php

/**
 * Include Theme Customizer
 *
 * @since v1.0
 */
$theme_customizer = get_template_directory() . '/inc/customizer.php';
if (is_readable($theme_customizer)) {
	require_once $theme_customizer;
}


/**
 * Include Support for wordpress.com-specific functions.
 * 
 * @since v1.0
 */
$theme_wordpresscom = get_template_directory() . '/inc/wordpresscom.php';
if (is_readable($theme_wordpresscom)) {
	require_once $theme_wordpresscom;
}

/**
 * General Theme Settings
 *
 * @since v1.0
 */
if (!function_exists('lyra_assessment_setup_theme')) :
	function lyra_assessment_setup_theme()
	{
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain('lyra-assessment', get_template_directory() . '/languages');

		// Theme Support.
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			array(
				'caption',
				'script',
				'style',
			)
		);

		// Add support for Block Styles.
		add_theme_support('wp-block-styles');
		// Add support for full and wide alignment.
		add_theme_support('align-wide');
		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Default Attachment Display Settings.
		update_option('image_default_align', 'none');
		update_option('image_default_link_type', 'none');
		update_option('image_default_size', 'large');
	}
	add_action('after_setup_theme', 'lyra_assessment_setup_theme');

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
	remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');
endif;


/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 *
 * @since v2.2
 */
if (!function_exists('wp_body_open')) :
	function wp_body_open()
	{
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since v2.2
		 */
		do_action('wp_body_open');
	}
endif;

/**
 * Test if a page is a blog page
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 */
function is_blog()
{
	global $post;
	$posttype = get_post_type($post);

	return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
}

/**
 * Loading All CSS Stylesheets and Javascript Files
 *
 * @since v1.0
 */
function lyra_assessment_scripts_loader()
{
	$theme_version = wp_get_theme()->get('Version');

	// 1. Styles.
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all');
	wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.

	// 2. Scripts.
	wp_enqueue_script('mainjs', get_template_directory_uri() . '/assets/js/main.bundle.js', array('jquery'), $theme_version, true);
}
add_action('wp_enqueue_scripts', 'lyra_assessment_scripts_loader');



/**
 * Start Lyra Health Assessment
 */

// Creating a Events Custom Post Type
function events_custom_post_type()
{
	$labels = array(
		'name'                => __('Events'),
		'singular_name'       => __('Event'),
		'menu_name'           => __('Events'),
		'parent_item_colon'   => __('Parent Event'),
		'all_items'           => __('All Events'),
		'view_item'           => __('View Event'),
		'add_new_item'        => __('Add New Event'),
		'add_new'             => __('Add New'),
		'edit_item'           => __('Edit Event'),
		'update_item'         => __('Update Event'),
		'search_items'        => __('Search Event'),
		'not_found'           => __('Not Found'),
		'not_found_in_trash'  => __('Not found in Trash')
	);
	$args = array(
		'label'               => __('event'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
		'yarpp_support'       => true,
		// 'taxonomies' 	      => array('post_tag'),
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type('event', $args);
}
add_action('init', 'events_custom_post_type', 0);



// Create Taxonomy for Events Custom Post Type
add_action('init', 'create_events_custom_taxonomy', 0);

// create a custom taxonomy name it "event_type" for your posts
function create_events_custom_taxonomy()
{

	$labels = array(
		'name' => _x('Event Types', 'taxonomy general name'),
		'singular_name' => _x('Event Type', 'taxonomy singular name'),
		'search_items' =>  __('Search Event Types'),
		'all_items' => __('All Event Types'),
		'parent_item' => __('Parent Event Type'),
		'parent_item_colon' => __('Parent Event Type:'),
		'edit_item' => __('Edit Event Type'),
		'update_item' => __('Update Event Type'),
		'add_new_item' => __('Add New Event Type'),
		'new_item_name' => __('New Event Type Name'),
		'menu_name' => __('Event Types'),
	);

	register_taxonomy('event_type', array('event'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'event-type'),
	));
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_post_meta_boxes()
{
	add_meta_box(
		'start-date',      // Unique ID
		'Start Date',    // Title
		'display_meta_box',   // Callback function
		'event',         // Admin page (or post type)
		'normal',         // Context
		'default'         // Priority
	);
}

add_action('add_meta_boxes', 'add_post_meta_boxes');


/* Display the post meta box. */
function display_meta_box($post)
{ ?>
	<?php wp_nonce_field(basename(__FILE__), 'start_date_nonce'); ?>

	<input type="date" name="start-date" value="<?php echo esc_attr(get_post_meta($post->ID, 'start_date', true)); ?>" />
<?php }


/* Save the meta box’s post metadata. */
function save_start_date_meta($post_id, $post)
{

	/* Verify the nonce before proceeding. */
	if (!isset($_POST['start_date_nonce']) || !wp_verify_nonce($_POST['start_date_nonce'], basename(__FILE__)))
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object($post->post_type);

	/* Check if the current user has permission to edit the post. */
	if (!current_user_can($post_type->cap->edit_post, $post_id))
		return $post_id;

	/* Get the posted data and sanitize it */
	$new_meta_value = (isset($_POST['start-date']) ? $_POST['start-date'] : '');

	/* Get the meta key. */
	$meta_key = 'start_date';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta($post_id, $meta_key, true);

	/* If a new meta value was added and there was no previous value, add it. */
	if ($new_meta_value && '' == $meta_value)
		add_post_meta($post_id, $meta_key, $new_meta_value, true);

	/* If the new meta value does not match the old value, update it. */
	elseif ($new_meta_value && $new_meta_value != $meta_value)
		update_post_meta($post_id, $meta_key, $new_meta_value);

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ('' == $new_meta_value && $meta_value)
		delete_post_meta($post_id, $meta_key, $meta_value);
}

/* Save post meta on the 'save_post' hook. */
add_action('save_post', 'save_start_date_meta', 10, 2);



function init()
{
	$title = 'hello world lorem ipsum';
	$title = str_ireplace(' lorem ipsum', '', $title);
	return apply_filters('update_title', $title, 10, 3);
}
