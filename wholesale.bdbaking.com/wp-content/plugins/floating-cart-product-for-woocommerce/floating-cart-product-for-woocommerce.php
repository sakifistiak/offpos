<?php
/**
* Plugin Name: Floating Cart Product For Woocommerce 
* Description: This plugin allows you to Create Sidebar cart in WooCommerce.
* Version: 1.2
* Copyright: 2023
* Text Domain: floating-cart-product-for-woocommerce
*/

if (!defined('FCPFW_PLUGIN_DIR')) {
  define('FCPFW_PLUGIN_DIR',plugins_url('', __FILE__));
}


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Include All Files

//Backend Property
include_once('main/backend/fcpfw_backend.php');

include_once('main/backend/fcpfw_backend_action.php');
include_once('main/backend/fcpfw_comman.php');
include_once('main/backend/fcpfw_svg.php');

//Fronend Design
include_once('main/frontend/fcpfw_front.php');
include_once('main/frontend/fcpfw_front_function.php');
include_once('main/frontend/fcpfw_head_foot.php');

//Js css Instaal Requrired file
include_once('main/resource/fcpfw_load_js_css.php');
include_once('main/resource/fcpfw-installation-require.php');

function FCPFWP_support_and_rating_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ($plugin_file_name !== plugin_basename(__FILE__)) {
      return $links_array;
    }

    $links_array[] = '<a href="https://www.plugin999.com/support/">'. __('Support', 'floating-cart-product-for-woocommerce') .'</a>';
    $links_array[] = '<a href="https://wordpress.org/support/plugin/floating-cart-product-for-woocommerce/reviews/?filter=5">'. __('Rate the plugin ★★★★★', 'floating-cart-product-for-woocommerce') .'</a>';

    return $links_array;

}
add_filter( 'plugin_row_meta', 'FCPFWP_support_and_rating_links', 10, 4 );

add_action('wp_enqueue_scripts', 'fcpfw_enqueue_cart_autoclose_script');
function fcpfw_enqueue_cart_autoclose_script() {
    wp_enqueue_script(
        'fcpfw_cart_auto_close',
        plugin_dir_url(__FILE__) . 'assets/js/fcpfw_cart_auto_close.js',
        array('jquery'),
        '1.0',
        true
    );
}



