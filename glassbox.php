<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              author_uri
 * @since             1.0.0
 * @package           Glassbox
 *
 * @wordpress-plugin
 * Plugin Name:       Glassbox News
 * Plugin URI:        http://glassbox.news
 * Description:       A plugin for opening revisions to your posts and produce transparent content.
 * Version:           0.1.0
 * Author:            Noé Domínguez-Porras
 * Author URI:        http://noedominguez.com
 * License:           AGPL-3.0+
 * License URI:       https://www.gnu.org/licenses/agpl-3.0.html
 * Text Domain:       glassbox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GLASSBOX_VERSION', '0.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-glassbox-activator.php
 */
function activate_glassbox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-glassbox-activator.php';
	Glassbox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-glassbox-deactivator.php
 */
function deactivate_glassbox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-glassbox-deactivator.php';
	Glassbox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_glassbox' );
register_deactivation_hook( __FILE__, 'deactivate_glassbox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-glassbox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_glassbox() {

	$plugin = new Glassbox();
	$plugin->run();

}
run_glassbox();
