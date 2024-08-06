<?php

/**
 * Plugin Name: Product Recommendation
 * Description: This is the custom plugin which helps to display product based on selected category.
 * Version: 1.0.0
 * Requires at least: 5.9
 * Requires PHP: 7.2
 * Author: wpwoocommercedemo
 * Text Domain: product-recommendation
*/


if(!defined('ABSPATH')){
    echo"What are you trying to do exactly?";
    exit;
}


if(!class_exists('ProductRecommendationPlugin')){

class ProductRecommendationPlugin{
    public function __construct(){
        define('myPluginPath', plugin_dir_path(__FILE__));
        define('myPluginUrl', plugin_dir_url(__FILE__));
    }

    public function initialize(){
        include_once myPluginPath . 'includes/recommend-products.php';
        // include_once myPluginPath . 'includes/select-QNA-form.php';
    }
}

$obj_ProductRecommendationPlugin = new ProductRecommendationPlugin;
$obj_ProductRecommendationPlugin -> initialize();

}

