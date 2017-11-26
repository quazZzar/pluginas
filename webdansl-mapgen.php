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
		require dirname( __FILE__ ) . '/framework/bootstrap.php';
		add_action( 'init', array($this, 'mapgen_setup_post_types'));
		add_action( 'add_meta_boxes', array( $this, 'mapgen_add_metabox'));
        add_action( 'save_post', array( $this, 'mapgen_save_metabox'));
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

	# Adding the metaboxes for the post types
    public function mapgen_add_metabox( $post_type ) {
        if ( in_array( $post_type, array('agents') ) ) {
            add_meta_box(
            	'mapgen_agents_metaboxes', 
            	__( 'Agent Options', 'mapgen' ),
                array( $this, 'mapgen_render_meta_box_content' ),
                'agents',
                'advanced',
                'high'
            );
        }
    }

    public function mapgen_save_metabox( $post_id ) {
        # Check if our nonce is set.
        if ( ! isset( $_POST['mapgen_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
        $nonce = $_POST['mapgen_inner_custom_box_nonce'];
        # Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'mapgen_inner_custom_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
 
        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
 
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $agent_practice_name = sanitize_text_field( $_POST['agent_practice_name'] );
 
        // Update the meta field.
        update_post_meta( $post_id, 'agent_practice_name', $agent_practice_name );
    }
 
    public function mapgen_render_meta_box_content( $post ) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'mapgen_inner_custom_box', 'mapgen_inner_custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $agent_practice_name = get_post_meta( $post->ID, 'agent_practice_name', true );
 
        // Display the form, using the current value.
        ?>
        <div class="input_pair">
	        <label for="agent_practice_name">
	            <?php _e( 'Practice Name', 'mapgen' ); ?>
	        </label>
	        <input type="text" id="agent_practice_name" name="agent_practice_name" value="<?php echo esc_attr( $agent_practice_name ); ?>" />
        </div>
        <?php
    }
}

if(class_exists('Webdansl_MapGen')){
	$new_Webdansl_MapGen = new Webdansl_MapGen();	
}

#On Activation
register_activation_hook( __FILE__, array($new_Webdansl_MapGen, 'activate'));

#On Deactivation
register_deactivation_hook( __FILE__, array($new_Webdansl_MapGen, 'deactivate'));