<?php
namespace lexweb\AMERICARE;

class LWD_Caregivers {
		
	public function __construct(){
		$this->printout = "Hi. We have an LWD_Caregivers instance.";
	}

	public function testing(){
		echo $this->printout;
	}
	
	/**
	 * Register Caregiver post type.
	 *
	 * @since 1.0.0
	 */
	public static function register_post_type() {

		// Get values and sanitize
		$name          = 'caregivers';
		$singular_name = 'Caregiver';
		$slug          = 'caregiver';
		$menu_icon     = 'universal-access';

		// Declare args and apply filters
		$args = array(
			'labels' => array(
				'name' => $name,
				'singular_name' => $singular_name,
				'add_new' => __( 'Add New', 'total' ),
				'add_new_item' => __( 'Add New Item', 'total' ),
				'edit_item' => __( 'Edit Item', 'total' ),
				'new_item' => __( 'Add New Caregiver Item', 'total' ),
				'view_item' => __( 'View Item', 'total' ),
				'search_items' => __( 'Search Items', 'total' ),
				'not_found' => __( 'No Items Found', 'total' ),
				'not_found_in_trash' => __( 'No Items Found In Trash', 'total' )
			),
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'custom-fields',
				'revisions',
				'author',
				'page-attributes',
			),
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => $slug, 'with_front' => false ),
			'has_archive' => true,
			'menu_icon' => 'dashicons-'. $menu_icon,
			'menu_position' => 20,
		);

		// Register the post type
		register_post_type( 'caregivers', $args );

	}

	/**
	 * Register Caregiver tags.
	 *
	 * @since 2.0.0
	 */
	public static function register_tags() {

		// Define and sanitize options
		$name = __( 'Caregiver Tags', 'total' );
		$slug = 'caregiver-tag';

		// Define args and apply filters for child theming
		$args = array(
			'labels' => array(
				'name' => $name,
				'singular_name' => $name,
				'menu_name' => $name,
				'search_items' => __( 'Search Caregiver Tags', 'total' ),
				'popular_items' => __( 'Popular Caregiver Tags', 'total' ),
				'all_items' => __( 'All Caregiver Tags', 'total' ),
				'parent_item' => __( 'Parent Caregiver Tag', 'total' ),
				'parent_item_colon' => __( 'Parent Caregiver Tag:', 'total' ),
				'edit_item' => __( 'Edit Caregiver Tag', 'total' ),
				'update_item' => __( 'Update Caregiver Tag', 'total' ),
				'add_new_item' => __( 'Add New Caregiver Tag', 'total' ),
				'new_item_name' => __( 'New Caregiver Tag Name', 'total' ),
				'separate_items_with_commas' => __( 'Separate caregiver tags with commas', 'total' ),
				'add_or_remove_items' => __( 'Add or remove caregiver tags', 'total' ),
				'choose_from_most_used' => __( 'Choose from the most used caregiver tags', 'total' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => false,
			'rewrite' => array( 'slug' => $slug, 'with_front' => false ),
			'query_var' => true
		);

		// Register the caregiver tag taxonomy
		register_taxonomy( 'caregiver_tag', array( 'caregiver' ), $args );

	}		
} // EOF LWD_Caregivers
?>