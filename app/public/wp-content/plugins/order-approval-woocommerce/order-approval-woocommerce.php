<?php

/**
 * Plugin Name:          Order Approval for Woocommerce
 * Plugin URI:           https://sevengits.com/plugin/order-approval-woocommerce-pro/
 * Description:          WooCommerce Order Approval plugin allowing shop owners to approve or reject all the orders placed by customers before payment processed.
 * Version:              2.1.5
 * Author:               Sevengits
 * Author URI:           https://sevengits.com/
 * License:              GPL-2.0+
 * License URI:          http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:          order-approval-woocommerce
 * Domain Path:          /languages
 * Requires at least: 3.7
 * Tested up to:      8.6
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if (!function_exists('get_plugin_data')) {
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if (!defined('SG_ORDER_APPROVAL_WOOCOMMERCE_VERSION')) {
	define('SG_ORDER_APPROVAL_WOOCOMMERCE_VERSION', get_plugin_data(__FILE__)['Version']);
}
if (!defined('SG_BASE_ORDER')) {
	define('SG_BASE_ORDER', plugin_basename(__FILE__));
}
if (!defined('SG_PLUGIN_PATH_ORDER')) {
	define('SG_PLUGIN_PATH_ORDER', plugin_dir_path(__FILE__));
}

if (!defined('WOA_DIR_PATH')) {
	define('WOA_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!class_exists('\OAWOO\Reviews\Notice')) {
	require plugin_dir_path(__FILE__) . 'includes/packages/plugin-review/notice.php';
}
function oawoo_disabled_plugin_depencies_unavailable()
{
	$depended_plugins = array(
		array(
			'plugins' => array(
				'WooCommerce' => 'woocommerce/woocommerce.php'
			), 'links' => array(
				'free' => 'https://wordpress.org/plugins/woocommerce/'
			)
		)

	);
	$message = __('The following plugins are required for <b>' . get_plugin_data(__FILE__)['Name'] . '</b> plugin to work. Please ensure that they are activated: ', 'order-approval-woocommerce');
	$is_disabled = false;
	foreach ($depended_plugins as $key => $dependency) {
		$dep_plugin_name = array_keys($dependency['plugins']);
		$dep_plugin = array_values($dependency['plugins']);
		if (count($dep_plugin) > 1) {
			if (!in_array($dep_plugin[0], apply_filters('active_plugins', get_option('active_plugins'))) && !in_array($dep_plugin[1], apply_filters('active_plugins', get_option('active_plugins')))) {
				$class = 'notice notice-error is-dismissible';
				$is_disabled = true;
				if (isset($dependency['links'])) {
					if (array_key_exists('free', $dependency['links'])) {
						$message .= '<br/> <a href="' . $dependency['links']['free'] . '" target="_blank" ><b>' . $dep_plugin_name[0] . '</b></a>';
					}
					if (array_key_exists('pro', $dependency['links'])) {

						$message .= ' Or <a href="' . $dependency['links']['pro'] . '" target="_blank" ><b>' . $dep_plugin_name[1] . '</b></a>';
					}
				} else {
					$message .= "<br/> <b> $dep_plugin_name[0] </b> Or <b> $dep_plugin_name[1] . </b>";
				}
			}
		} else {
			if (!in_array($dep_plugin[0], apply_filters('active_plugins', get_option('active_plugins')))) {
				$class = 'notice notice-error is-dismissible';
				$is_disabled = true;
				if (isset($dependency['links'])) {
					$message .= '<br/> <a href="' . $dependency['links']['free'] . '" target="_blank" ><b>' . $dep_plugin_name[0] . '</b></a>';
				} else {
					$message .= "<br/><b>$dep_plugin_name[0]</b>";
				}
			}
		}
	}
	if ($is_disabled) {
		if (!defined('OAWOO_DISABLED')) {
			define('OAWOO_DISABLED', true);
		}
		printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
	}

	/**
	 * plugin review notice
	 */

	$message = sprintf(__("Hello! Seems like you have been using %s for a while – that’s awesome! Could you please do us a BIG favor and give it a 5-star rating on WordPress? This would boost our motivation and help us spread the word.", 'order-approval-woocommerce'), "<b>" . get_plugin_data(__FILE__)['Name'] . "</b>");
	$actions = array(
		'review'  => __('Ok, you deserve it', 'order-approval-woocommerce'),
		'later'   => __('Nope, maybe later', 'order-approval-woocommerce'),
		'dismiss' => __('Already did', 'order-approval-woocommerce'),
	);
	if (class_exists('\OAWOO\Reviews\Notice')) {
		// delete_site_option('oawoo_reviews_time');

		$notice = \OAWOO\Reviews\Notice::get(
			'order-approval-woocommerce',
			get_plugin_data(__FILE__)['Name'],
			array(
				'days'          => 7,
				'message'       => $message,
				'action_labels' => $actions,
				'prefix' => "oawoo"
			)
		);

		// Render notice.
		$notice->render();
	}
}
add_action('admin_notices', 'oawoo_disabled_plugin_depencies_unavailable');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sg-order-approval-woocommerce-activator.php
 */
function oawoo_activate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce-activator.php';
	Sg_Order_Approval_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sg-order-approval-woocommerce-deactivator.php
 */
function oawoo_deactivate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce-deactivator.php';
	Sg_Order_Approval_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'oawoo_activate');
register_deactivation_hook(__FILE__, 'oawoo_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-woocommerce.php';
/**
 * Plugin Deactivation Survey
 */
require plugin_dir_path(__FILE__) . 'plugin-deactivation-survey/deactivate-feedback-form.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function oawoo_run()
{
	if (defined('OAWOO_DISABLED')) {
		return;
	}

	$plugin = new Sg_Order_Approval_Woocommerce();
	$plugin->run();
}
oawoo_run();

add_filter('sgits_deactivate_feedback_form_plugins', function ($plugins) {
	$plugins[] = (object)array(
		'slug'		=> 'order-approval-woocommerce',
		'version'	=> SG_ORDER_APPROVAL_WOOCOMMERCE_VERSION
	);
	return $plugins;
});

// Hook the custom function to the 'before_woocommerce_init' action
add_action('before_woocommerce_init', 'oawoo_declare_cart_checkout_blocks_compatibility');

/**
 * Custom function to declare compatibility with cart_checkout_blocks feature
 * @since 2.1.0
 */
function oawoo_declare_cart_checkout_blocks_compatibility()
{
	// Check if the required class exists
	if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks', __FILE__, true);
	}
}


// Hook the custom function to the 'woocommerce_blocks_loaded' action
add_action('woocommerce_blocks_loaded', 'oawoo_register_order_approval_payment_method_type');

/**
 * Custom function to register a payment method type
 * @since 2.1.0
 */
function oawoo_register_order_approval_payment_method_type()
{
	// Check if the required class exists
	if (!class_exists('Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType')) {
		return;
	}

	// Include the custom Blocks Checkout class
	require_once plugin_dir_path(__FILE__) . 'includes/class-sg-order-approval-wocommerce-block-checkout.php';

	// Hook the registration function to the 'woocommerce_blocks_payment_method_type_registration' action
	add_action(
		'woocommerce_blocks_payment_method_type_registration',
		function (Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry) {
			// Register an instance of Woa_Order_Blocks
			$payment_method_registry->register(new Woa_Order_Blocks());
		}
	);
}
?>