<?php

/**
 * Fired during plugin deactivation
 *
 * @link       author_uri
 * @since      1.0.0
 *
 * @package    Glassbox
 * @subpackage Glassbox/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Glassbox
 * @subpackage Glassbox/includes
 * @author     Noé Domínguez-Porras <zeugop@gmail.com>
 */
class Glassbox_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
