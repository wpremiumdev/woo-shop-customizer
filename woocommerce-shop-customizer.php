<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Woo Shop Customizer
 * Plugin URI:        https://www.premiumdev.com/
 * Description:       This plugin allow user to Customize WooCommerce Shop 
 * Version:           1.0.7
 * Author:            mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 * Author URI:        https://www.premiumdev.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-shop-customizer
 * Domain Path:       /languages
 */
// If this file is called directly, abort.

if (!defined('WPINC')) {
    die;
}

if (!defined('WOO_SHOP_PLUGIN_BASE_NAME')) {
    define('WOO_SHOP_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-shop-customizer-activator.php
 */
function activate_woocommerce_shop_customizer() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-shop-customizer-activator.php';
    Woocommerce_Shop_Customizer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-shop-customizer-deactivator.php
 */
function deactivate_woocommerce_shop_customizer() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-shop-customizer-deactivator.php';
    Woocommerce_Shop_Customizer_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woocommerce_shop_customizer');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_shop_customizer');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-shop-customizer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_shop_customizer() {

    $plugin = new Woocommerce_Shop_Customizer();
    $plugin->run();
}

run_woocommerce_shop_customizer();
