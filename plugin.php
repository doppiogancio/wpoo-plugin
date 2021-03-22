<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Fabrizio Gargiulo
 * @since             1.0.0
 * @package           WPOO Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       WPOO Plugin
 * Plugin URI:        www/wpoo-plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mr Demo
 * Author URI:        Mr Demo
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpoo-plugin
 * Domain Path:       /languages
 */
use WPOO\Plugin\Activator;
use WPOO\Plugin\Deactivator;
use WPOO\Plugin\Plugin;
use WPOO\Plugin\Shortcode\Shortcode;

if ( ! defined( 'WPINC' ) ) {
    die;
}

define('WPOO_PLUGIN_DIR', '/var/www/html/wp-content/plugins/wpoo-plugin/');
define('WPOO_PLUGIN_URL', plugin_dir_url( __FILE__));

require_once "vendor/autoload.php";

register_activation_hook(__FILE__, function () {
    Activator::activate();
});

register_deactivation_hook(__FILE__, function () {
    Deactivator::deactivate();
});

$plugin = new WPOO\XmlTransformer\Plugin('wpoo-plugin', '1.0.0');
$plugin->run();

