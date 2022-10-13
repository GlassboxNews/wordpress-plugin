<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Glassbox
 * @subpackage Glassbox/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Glassbox
 * @subpackage Glassbox/includes
 * @author     Noé Domínguez-Porras <zeugop@gmail.com>
 */
class Glassbox_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array(
			array(
				'hook'          => 'init',
				'component'     => $this,
				'callback'      => 'glassbox_root_redirect',
				'priority'      => 0,
				'accepted_args' => 0
			),
			array(
				'hook'          => 'template_redirect',
				'component'     => $this,
				'callback'      => 'glassbox_endpoints_redirect',
				'priority'      => 0,
				'accepted_args' => 0
			)
		);
		$this->filters = array(
			array(
			'hook'          => 'query_vars',
			'component'     => $this,
			'callback'      => 'glassbox_query_vars',
			'priority'      => 0,
			'accepted_args' => 1
			)
	    );

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

	/**
	 * Add new query var for Glassbox.
	 *
	 * @param array $query_vars
	 * @return array
	 */
	public function glassbox_query_vars( $query_vars ) {
		$query_vars[] = 'glassbox';
		return $query_vars;
	}

	/**
	 * Add new redirect for glassbox
	 *
	 * @return void
	 */
	public function glassbox_root_redirect() {
		add_rewrite_rule("^glassbox/?$", "index.php?rest_route=/wp/v2/glassbox", 'top');
		add_rewrite_endpoint("glassbox",  EP_PERMALINK | EP_PAGES);
		flush_rewrite_rules();
	}

	public function glassbox_endpoints_redirect() {
		global $wp_query;

		// if this is not a request for json or it's not a singular object then bail
		if ( ! isset( $wp_query->query_vars['glassbox'] ) || ! is_singular() ){
			return;
		}
		// redirect to wp-json registered endpoint for Glassbox
		$post = get_queried_object();
		$url = "/wp-json/wp/v2/posts/{$post->ID}/glassbox";
		wp_redirect( $url );
		exit;
	}

}
