<?php
/*
Plugin Name: Woocommerce easy booking system
Plugin URI: 
Description: Allows users to rent or book products
Version: 1.0
Author: Natasha Lavail
Author URI: http://ashanna.com
Licence : GPL
*/

function wc_ebs_init() {
    // Check if WooCommerce is active
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        include_once('wc_ebs_plugin.php');
        include_once('wc-ebs-cart-actions.php');
        include_once('options/wc_ebs_options.php');
    }
}

add_action('plugins_loaded', 'wc_ebs_init', 10);

function add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=wc_ebs_options">'.__('Settings','wc_ebs').'</a>';
    array_push( $links, $settings_link );
    return $links;
}

// add settings link
$plugin = plugin_basename( __FILE__ );
add_filter( 'plugin_action_links_' . $plugin, 'add_settings_link');

load_plugin_textdomain('wc_ebs', false, basename(dirname(__FILE__)).'/languages/');
