<?php
/**
 * Plugin Name: HappyMap
 * Plugin URI: https://avirtum.com/happymap/
 * Description: HappyMap is a plugin that enables you add google maps to your WordPress website.
 * Version: 1.0.0
 * Requires at least: 4.6
 * Requires PHP: 7.0
 * Author: Avirtum
 * Author URI: https://avirtum.com
 * License: GPLv3
 * Text Domain: happymap
 * Domain Path: /languages
 */
namespace HappyMap;

defined( 'ABSPATH' ) || exit;

define( 'HAPPYMAP_PLUGIN_NAME', 'happymap' );
define( 'HAPPYMAP_PLUGIN_VERSION', '1.0.0' );
define( 'HAPPYMAP_SHORTCODE_NAME', 'happymap' );
define( 'HAPPYMAP_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'HAPPYMAP_PLUGIN_FILE', __FILE__ );
define( 'HAPPYMAP_PLUGIN_BASE_NAME', plugin_basename(__FILE__) );

spl_autoload_register(function($class) {
    $prefix = __NAMESPACE__;
    $base = __DIR__ . '/includes/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

Plugin::run();