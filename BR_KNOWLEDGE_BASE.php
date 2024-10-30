<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              blueroosterthemes.com
 * @since             1.0.0
 * @package           BR_KNOWLEDGE_BASE
 *
 * @wordpress-plugin
 * Plugin Name:       Blue Rooster Knowledge  
 * Plugin URI:        blueroosterthemes.com
 * Description:       Create an attractive online help knowledge base from your WordPress dashboard with Blue Rooster Knowledge Base. This ready to use plugin has been designed and used by technical writers across the globe.
 * Version:           1.0.0
 * Author:            zulmkodr
 * Author URI:        blueroosterthemse.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blue-rooster
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
define( 'BR_KNOWLEDGE_BASE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-BR_KNOWLEDGE_BASE-activator.php
 */
function activate_BR_KNOWLEDGE_BASE() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-BR_KNOWLEDGE_BASE-activator.php';
	BR_KNOWLEDGE_BASE_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-BR_KNOWLEDGE_BASE-deactivator.php
 */
function deactivate_BR_KNOWLEDGE_BASE() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-BR_KNOWLEDGE_BASE-deactivator.php';
	BR_KNOWLEDGE_BASE_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_BR_KNOWLEDGE_BASE' );
register_deactivation_hook( __FILE__, 'deactivate_BR_KNOWLEDGE_BASE' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-BR_KNOWLEDGE_BASE.php';
require plugin_dir_path( __FILE__ ) . 'route.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_BR_KNOWLEDGE_BASE() {

	$plugin = new BR_KNOWLEDGE_BASE();
	$plugin->run();

}
run_BR_KNOWLEDGE_BASE();
