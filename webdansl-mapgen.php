<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name:  MapGen - Webdansl
Description:  PDF Generator
Version:      1.0
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  mapgen
*/

class Webdansl_MapGen{
	# The class constructor
	public function __construct(){
		require dirname( __FILE__ ) . '/meta-box/meta-box.php';
		require dirname( __FILE__ ) . '/webdansl_metaboxes.php';
		require dirname( __FILE__ ) . '/webdansl_settings.php';
		add_action( 'init', array($this, 'mapgen_setup_post_types'));
		add_action( 'after_setup_theme', array($this, 'mapgen_support_features'), 11 );
	}

	# Triggers on plugin activation, flushes the rewrite rules
	public function activate(){
		$this->mapgen_setup_post_types();
		flush_rewrite_rules();
	}

	# Triggers on plugin deactivation, flushes the rewrite rules
	public function deactivate(){
		flush_rewrite_rules();
	}

	# Registering the custom post types
	public function mapgen_setup_post_types(){

		# Creating the Agents custom post type
		$labels = array(
			'name'               => _x( 'Agents', 'post type general name', 'mapgen' ),
			'singular_name'      => _x( 'Agent', 'post type singular name', 'mapgen' ),
			'menu_name'          => _x( 'Agents', 'admin menu', 'mapgen' ),
			'name_admin_bar'     => _x( 'Agent', 'add new on admin bar', 'mapgen' ),
			'add_new'            => _x( 'Add New', 'agent', 'mapgen' ),
			'add_new_item'       => __( 'Add New Agent', 'mapgen' ),
			'new_item'           => __( 'New Agent', 'mapgen' ),
			'edit_item'          => __( 'Edit Agent', 'mapgen' ),
			'view_item'          => __( 'View Agent', 'mapgen' ),
			'all_items'          => __( 'All Agents', 'mapgen' ),
			'search_items'       => __( 'Search Agents', 'mapgen' ),
			'parent_item_colon'  => __( 'Parent Agents:', 'mapgen' ),
			'not_found'          => __( 'No agents found.', 'mapgen' ),
			'not_found_in_trash' => __( 'No agents found in Trash.', 'mapgen' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'mapgen' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'agents' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 110,
			'menu_icon'			 => 'dashicons-businessman',
			'supports'           => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		);
		register_post_type( 'agents', $args );

		# Creating the Venues custom post type
		$labels = array(
			'name'               => _x( 'Venues', 'post type general name', 'mapgen' ),
			'singular_name'      => _x( 'Venue', 'post type singular name', 'mapgen' ),
			'menu_name'          => _x( 'Venues', 'admin menu', 'mapgen' ),
			'name_admin_bar'     => _x( 'Venue', 'add new on admin bar', 'mapgen' ),
			'add_new'            => _x( 'Add New', 'venue', 'mapgen' ),
			'add_new_item'       => __( 'Add New Venue', 'mapgen' ),
			'new_item'           => __( 'New Venue', 'mapgen' ),
			'edit_item'          => __( 'Edit Venue', 'mapgen' ),
			'view_item'          => __( 'View Venue', 'mapgen' ),
			'all_items'          => __( 'All Venues', 'mapgen' ),
			'search_items'       => __( 'Search Venues', 'mapgen' ),
			'parent_item_colon'  => __( 'Parent Venues:', 'mapgen' ),
			'not_found'          => __( 'No venues found.', 'mapgen' ),
			'not_found_in_trash' => __( 'No venues found in Trash.', 'mapgen' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'mapgen' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'venues' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 110,
			'menu_icon'			 => 'dashicons-location-alt',
			'supports'           => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		);
		register_post_type( 'venues', $args );

		# Creating the Templates custom post type
		$labels = array(
			'name'               => _x( 'Templates', 'post type general name', 'mapgen' ),
			'singular_name'      => _x( 'Template', 'post type singular name', 'mapgen' ),
			'menu_name'          => _x( 'Templates', 'admin menu', 'mapgen' ),
			'name_admin_bar'     => _x( 'Template', 'add new on admin bar', 'mapgen' ),
			'add_new'            => _x( 'Add New', 'template', 'mapgen' ),
			'add_new_item'       => __( 'Add New Template', 'mapgen' ),
			'new_item'           => __( 'New Template', 'mapgen' ),
			'edit_item'          => __( 'Edit Template', 'mapgen' ),
			'view_item'          => __( 'View Template', 'mapgen' ),
			'all_items'          => __( 'All Templates', 'mapgen' ),
			'search_items'       => __( 'Search Templates', 'mapgen' ),
			'parent_item_colon'  => __( 'Parent Templates:', 'mapgen' ),
			'not_found'          => __( 'No templates found.', 'mapgen' ),
			'not_found_in_trash' => __( 'No templates found in Trash.', 'mapgen' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'mapgen' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'templates' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 110,
			'menu_icon'			 => 'dashicons-media-text',
			'supports'           => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		);
		register_post_type( 'templates', $args );
	}

	public function mapgen_support_features(){
		add_theme_support( 'post-thumbnails' );
	}
}

if(class_exists('Webdansl_MapGen')){
	$new_Webdansl_MapGen = new Webdansl_MapGen();	
}

if(class_exists('RWMB_Loader')){
	if(class_exists('MapGenMeta')){
		$posts_metas = new MapGenMeta();
	}
}

if(class_exists('MapGenAdminSettings')){
	$admin_settings = new MapGenAdminSettings();
}


#On Activation
register_activation_hook( __FILE__, array($new_Webdansl_MapGen, 'activate'));

#On Deactivation
register_deactivation_hook( __FILE__, array($new_Webdansl_MapGen, 'deactivate'));
