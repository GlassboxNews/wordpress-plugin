<?php

class Glassbox_Initializer {

	public function __construct() {
	}

	public function add_action_to_rest_api() {
		add_action( 'rest_api_init', array( $this, 'init_glassbox_controller' ) );
	}

	public function init_glassbox_controller() {
		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			if ( post_type_supports( $post_type->name, 'revisions' ) ) {
				require_once plugin_dir_path( __FILE__ ) . 'class-glassbox-controller.php';
				$revisions_controller = new WP_REST_Glassbox_Controller( $post_type->name );
				$revisions_controller->register_routes();
			}
		}
	}
}
