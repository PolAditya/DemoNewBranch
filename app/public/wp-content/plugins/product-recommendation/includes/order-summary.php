<?php



// Add meta box to WooCommerce order page
add_action('woocommerce_checkout_update_order_meta', 'save_order_QNA_summary_data', 10,2);
add_action('add_meta_boxes', 'add_custom_order_QNA_meta_box');

function add_custom_order_QNA_meta_box()
{
    try{
        // Add meta box
        add_meta_box(
            'custom_order_meta_box', // Meta box ID
            'QNA Summary ', // Title of the meta box
            'render_custom_order_QNA_meta_box', // Callback function to render the meta box content
            'woocommerce_page_wc-orders', // Post type (WooCommerce order)
            'advanced', // Context (where the meta box will be displayed)
            'default' // Priority
        );

    }catch(Exception $e){
        error_log('Error iin adding summary meta box: ' . $e->getMessage());
    }
    
}


function render_custom_order_QNA_meta_box($post)
{

    try{
        // Get QNA summary meta data from the order
        $serialized_summary = get_post_meta($post->ID, 'QNA Summary', true);
        
        // Unserialize the data
        $order_QNA_summary = unserialize($serialized_summary);
        // Output QNA summary
        if ($order_QNA_summary && is_array($order_QNA_summary)) {
            echo '<ul>';
            

            foreach ($order_QNA_summary as $quiz => $questions) {
                echo '<li><strong>'.$quiz.'</strong></li>';
                foreach ($questions as $question => $answer ){
                    echo '<li><strong>' . $question . ':</strong> ' . $answer . '</li>';
                }
            }
            echo '</ul>';
        
        } else {
            print_r($order_QNA_summary);
            echo '<p>No QNA summary available for this order.</p>';
        }

    }catch(Exception $e){
        error_log('Error in dispaying summary meta: ' . $e->getMessage());
    }
    

    
}



function save_order_QNA_summary_data($order_id, $posted) {
   

    try{

        if (isset($_SESSION['summary'])) {
            $order_QNA_summary = $_SESSION['summary'];
    
            // Serialize the array before saving
            $serialized_summary = serialize($order_QNA_summary);
            update_post_meta($order_id, 'QNA Summary', $serialized_summary);
    
        }

    }catch(Exception $e){
        error_log('Error in saving QNA summary data: ' . $e->getMessage());
    }

    
}


// displaying question answer summary on checout page

// add_action('woocommerce_checkout_shipping', 'display_custom_order_summary');
// add_action('woocommerce_thankyou', 'display_custom_order_summary');

// function display_custom_order_summary() {

//     try{

//         if (!session_id()) {
//             session_start();
//         }
    
//         echo'<div class="order_summary_wrapper">';
    
//         echo '<p class="order_summary_heading">Order QNA Summary:</p>';
    
//         echo'<div class="order_summary_container">';
//         // Check if the session variable exists and has data
//         if (isset($_SESSION['summary']) && !empty($_SESSION['summary'])) {
//             echo '<ul>';
            
    
//             foreach ($_SESSION['summary'] as $quiz => $questions) {
//                 echo '<li><strong>'.$quiz.'</strong></li>';
//                 foreach ($questions as $question => $answer ){
//                     echo '<li><strong>' . $question . ':</strong> ' . $answer . '</li>';
//                 }   
//             }
//             echo '</ul>';
            
//         } else {
//             echo '<div>Their is no order summary to show.</div>';
//         }
//         echo'</div>';
//         echo'</div>';

//     }catch(Exception $e){
//         error_log('Error in displaying order summary: ' . $e->getMessage());
//     }

    

 
// }






// Unset session variables related to summary and selected category after order placement
add_action('woocommerce_thankyou', 'unset_session_variables_after_order');
function unset_session_variables_after_order($order_id) {
    if (!session_id()) {
        session_start();
    }
    
    session_unset();
    session_destroy();
    
}

// Unset session variables related to summary and selected category after user logout
add_action('wp_logout', 'unset_session_variables_after_logout');
function unset_session_variables_after_logout() {
    if (!session_id()) {
        session_start();
    }
    session_unset();
    session_destroy(); 
    
}

