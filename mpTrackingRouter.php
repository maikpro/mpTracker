<?php
/**

 * Plugin Name:       mpTrackingRouter

 * Description:       Show Referrer URLs from Costumers in WooCommerce Order 

 * Version:           1.0.0

 * Author:            Maik Proba

 * Author URI:        https://maikpro.github.io/

 * License:           GPL v2 or later

 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html

 * Text Domain:       mp-tracking-router

 */



defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*Add php File */
include( plugin_dir_path( __FILE__ ) . './admin/menu.php');
include( plugin_dir_path( __FILE__ ) . './tracking.php' );
/**/

/*Add JS File */
//wp_enqueue_script( "admin-js", plugin_dir_path( __FILE__ ) . "/js/admin.js" );
/**/

function admin_scripts() {
    wp_enqueue_script( "mpTrackingAdmin", plugin_dir_url(__FILE__) . "/js/mpTrackingAdmin.js", array(), false, true);
    wp_enqueue_style( "mpTrackingAdminStyle", plugin_dir_url(__FILE__) . "/css/style.css", array(), false, false );
}
add_action( 'admin_enqueue_scripts', 'admin_scripts' );





