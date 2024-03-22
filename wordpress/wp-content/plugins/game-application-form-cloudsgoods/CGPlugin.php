<?php
/*
Plugin Name: Game application form CloudsGoods
Plugin URI: https://cloudsgoods.com/
Description: Integrating loyalty programs to WordPress
Version: 1.0.0
Author: The CloudsGoods Team
Author URI: https://cloudsgoods.com
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/lib/autoload.php';
$vendorDir = dirname(dirname(__FILE__));
$baseDir = __DIR__;
define('CLOUDSGOODS__FILE__', '__FILE__');
define('CLOUDSGOODS_PLUGIN_BASE', plugin_basename(CLOUDSGOODS__FILE__));
define('CLOUDSGOODS_PLUGIN_ROOT', plugin_dir_path(__FILE__));
define('CLOUDSGOODS_PLUGIN_URL', plugins_url().'/'.plugin_basename(__DIR__));
require_once __DIR__.'/config/config.php';
$path = explode('/',__DIR__);
array_pop($path);
array_pop($path);
array_pop($path);
$siteRoot = implode('/', $path);
require_once $siteRoot.'/wp-includes/class-wp-widget.php';
/*
|--------------------------------------------------------------------------
| Run The Main Application
|--------------------------------------------------------------------------
|
*/
function cloudsgoods_plugin_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'cloudsgoods_data';

    $sql = "CREATE TABLE $table_name (
            optionid varchar(16) NOT NULL,
            data varchar(255)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'cloudsgoods_plugin_create_db');

$CloudsGoodsApp = new \CloudsGoodsApp\CloudsGoodsWidgetMainClass();
$CloudsGoodsApp->run();
