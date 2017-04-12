<?php
namespace lexweb\AMERICARE;

/**
 * Register a meta box using a class.
 */
		
class LWD_Custom_Meta_Box {
 
    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
 
    }
 
    /**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'hobbies-meta-box',
            __( 'Caregiver Details', 'textdomain' ),
            array( $this, 'render_metabox' ),
            'caregivers',
            'advanced',
            'default',
            'high'
        );
 
    }
 
    /**
     * Render hobbies meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'lwd_caregiver_action', 'lwd_caregiver_nonce' );
	
				// Noncename needed to verify where the data originated
				echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
				wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
				$hobbies = get_post_meta($post->ID, '_hobbies', true);
				$specializations = get_post_meta($post->ID, '_specializations', true);
	
				?>
				<label for="hobbies">Hobbies</label>
				<input type="text" name="_hobbies" value="<?=$hobbies?>" class="widefat" id="hobbies" />
				<label for="specializations">Specializations</label>
				<input type="text" name="_specializations" value="<?=$specializations?>" class="widefat" id="specializations" />
				<?php

    }
    
 
    /**
     * Saving meta boxes.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['lwd_caregiver_nonce'] ) ? $_POST['lwd_caregiver_nonce'] : '';
        $nonce_action = 'lwd_caregiver_action';
 
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        // Put it into an array to make it easier to loop though.
			
				$events_meta['_hobbies'] = $_POST['_hobbies'];
				$events_meta['_specializations'] = $_POST['_specializations'];
	
				// Add values of $events_meta as custom fields
	
				foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
					$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
					if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
						update_post_meta($post->ID, $key, $value);
					} else { // If the custom field doesn't have a value
						add_post_meta($post->ID, $key, $value);
					}
					if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
				}
    }
}
 
?>