<?php  

if(!defined('ABSPATH')){
    echo"What are you trying to do exactly?";
    exit;
}


add_action('plugins_loaded', 'start_session', 1);
function start_session() {
    if (!session_id()) {
        session_start();
    }
}




add_action('wp_enqueue_scripts', 'loadAssets');

add_shortcode('display_recommended_products', 'display_recommended_products_shortcode', 10);
// add to cart
add_action('wp_ajax_add_to_cart', 'add_to_cart_ajax_handler');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart_ajax_handler');




function loadAssets(){
    wp_enqueue_style(
        'product-template-style',
        myPluginUrl . 'assets/css/product-template-style.css',
        array(),
        1,
        'all'
    );    

    wp_enqueue_script(
        'recommended-product-script',
        myPluginUrl . 'assets/js/recommended-product.js',
        array('jquery'),
        1,
        true
    );
    
}



include myPluginPath . 'includes/select-QNA-form.php';




// updating the cart

function update_cart($selected_categories){
    
    
    try{

        $cart_contents = WC()->cart->get_cart();

        // Initialize an array to store product IDs belonging to selected categories
        $selected_product_ids = [];

        // Iterate through selected categories
        foreach ($selected_categories as $category) {
            // Get product IDs associated with the category
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'product_cat'    => $category,
                'fields'         => 'ids',
            );
           
            $products = get_posts($args);

            // Merge product IDs into the selected_product_ids array
            $selected_product_ids = array_merge($selected_product_ids, $products);
            
        }

        // Iterate through each item in the cart
        foreach ($cart_contents as $cart_item_key => $cart_item) {
            // Get the product ID of the cart item
            $product_id = $cart_item['product_id'];
           
            // Check if the product belongs to any of the selected categories
            if (!in_array($product_id, $selected_product_ids)) {
                // Remove the cart item if it does not belong to any selected category
                WC()->cart->remove_cart_item($cart_item_key);
            }
        } 

    }catch(Exception $e){
        error_log('Error in update_cart: ' . $e->getMessage());
    }

  
}




function retrive_products_based_on_categories($selected_categories){
    try{

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $selected_categories,
                ),
            ),
        );
    
        $products_query = new WP_Query($args);

        
        echo '<div class="product_container">';
        echo '<h2 class="product_wrapper_heading">' . 'Based on your preference, here are the products to choose from' . '</h2>';

        echo '<div class="product_wrapper">';
        if($products_query->have_posts()) {
            while($products_query->have_posts()) : $products_query->the_post();
               global $product;

                // Get product ID
                $product_id = $product->get_id();

                // Get product image
                $product_image = $product->get_image();

                // Get product title
                $product_title = get_the_title();

                // Get product price
                $product_regular_price = $product->get_regular_price();

                // Get product description
                $product_description = $product->get_description();

                // Get sale price
                $sale_price = $product->get_sale_price();

                // Get average rating
                $average_rating = $product->get_average_rating();

                // Get rating count
                $rating_count = $product->get_rating_count();

                ?>
                <div class="woocommerce_product">
                    <div class="product_image"><?php echo $product_image; ?></div>
                    <div class="product_details">
                        <div class="product_name"><?php echo $product_title; ?></div>
                        <div class="product_content">
                            <div class="product_rating_wrapper">
                                <div class="product_rating">
                                    <?php echo wc_get_rating_html($average_rating, $rating_count); ?>
                                </div>
                                <div class="rating_count">
                                    <?php echo $rating_count; ?>  
                                </div>
                            </div>   
                            <div class="product_price">
                                <?php
                                // Display sale price if available
                                if ($sale_price) {
                                    echo '<span class="regular_price">' . wc_price($product_regular_price) . '</span>';
                                    echo '<span class="sale_price">' . wc_price($sale_price) . '</span>';

                                } else {
                                    echo  '<span class="regular_price_alone">' . wc_price($product_regular_price) . '</span>';
                                }
                                ?>
                            </div>
                            <form class="add_to_cart_form" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button type="submit" class="btn_submit_to_cart">Add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
        }

        echo '</div>';
        echo '</div>';
        wp_reset_query();
        wp_reset_postdata();

        // return $products_query->posts;

    } catch (Exception $e) {
        // Log the error
        error_log('Error in retrieve_products_based_on_categories: ' . $e->getMessage());

        // Throw the exception to be caught in the calling function
        throw $e;
    }

}  








function display_recommended_products_shortcode() {

    try{
        // Start the session if it's not already started
        if (!session_id()) {
            session_start();
        }

        
        // Check if the session variable exists and has data
        if (isset($_SESSION['selected_categories']) && !empty($_SESSION['selected_categories'])) {
            // Get the path to the template file
            $template_path = plugin_dir_path(__FILE__) . 'template/display-product-template.php';

            // Output buffering to capture the template content
            ob_start();
            include $template_path; // Include the template file
            $output = ob_get_clean(); // Get the content and clean the buffer

            return $output;
        } else {
            return '<div>No categories selected.</div>';
        }
        
     } catch(Exception $e){
        error_log('Error in dispaying recommended product: ' . $e->getMessage());
        return '<div>No Products to show Please try againg later...</div>';
    }
    

    
}






function add_to_cart_ajax_handler(){
    try{

        if(isset($_POST['product_id'])){
            $get_product_id = intval($_POST['product_id']);
    
            $result = WC()->cart->add_to_cart($get_product_id);
    
            if($result){
                wp_send_json_success('Product added to cart successfully.');
            } else {
                wp_send_json_error('Failed to add product to cart.');
            } 
        }else{
            wp_send_json_error('Product ID is missing');
        }
        wp_die();

    }catch(Exception $e){
        $error_message = 'Error in adding product to cart: ' . $e->getMessage();
        error_log($error_message);
        wp_send_json_error($error_message);
    }

    
}




include myPluginPath . 'includes/order-summary.php';























// function close_session() {
//     session_write_close();
// }
// add_action('http_api_curl', 'close_session');   


















// function mymodule_curl_before_request($curlhandle){
//     session_write_close();
// }
// add_action( 'requests-curl.before_request','mymodule_curl_before_request', 9999 );