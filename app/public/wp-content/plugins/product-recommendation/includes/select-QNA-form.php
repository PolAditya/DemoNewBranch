<?php  

if(!defined('ABSPATH')){
    echo"What are you trying to do exactly?";
    exit;
}


add_action('multi-step-form/save', 'selecting_QNA_for_selected_category',10,3);
add_shortcode('QNA_form_shortcode', 'display_QNA_form', 10);



define("hair_care", 7);
define("Performance", 4);
define("skin_care", 10);

function selecting_QNA_for_selected_category($id, $data, $wizard){
    try{
        

        $form_id = $id;
        $form_data = $data;

        if($form_id == hair_care || $form_id == Performance){
            unsetting_sessions();
            $_SESSION['current_form_id'] = $form_id;
            selecting_category($form_data);
           
        }

        if($form_id == skin_care){
            handling_skin_care_data($form_data);
        }

        if (!($form_id == hair_care || $form_id == Performance || $form_id == skin_care)){
    
            updating_QNA_summary($form_id, $form_data);
            
        }
        
           
    }catch(Exception $e){
        error_log('Error in selecting_QNA_for_selected_category: ' . $e->getMessage());
    }
}


function unsetting_sessions(){
    try{
        if (!session_id()) {
            session_start();
        }

        if(isset($_SESSION['selected_categories']) && !empty($_SESSION['selected_categories'])){
            unset($_SESSION['selected_categories']);
          
        }

        if(isset( $_SESSION['current_form_id']) && !empty( $_SESSION['current_form_id'])){
            unset( $_SESSION['current_form_id']);
           
        }

    }catch(Exception $e){
        error_log('Error in unsetting_sessions: ' . $e->getMessage());
    }
}



// selecting category by hair care or performance
function selecting_category($data){
   try{
        if (!session_id()) {
            session_start();
        }

        $Category_array = [];
        $selected_options = [];
        foreach ($data as $section => $questions) {
            foreach($questions as $question){
                foreach($question as $que => $ans){
                    $selected_options[] = $ans;
                }
            }
            
        }

        $Category_array = array_unique($selected_options);
        $_SESSION['selected_categories'] = $Category_array;
        update_cart($Category_array); 

   }catch(Exception $e){
        error_log('Error in selecting_category: ' . $e->getMessage());
    }
    
}




// slecting category and handling summary specificaly for skin care
function handling_skin_care_data($form_data){
    try{
        if (!session_id()) {
            session_start();
        }

        if(isset($_SESSION['selected_categories']) && !empty($_SESSION['selected_categories'])){
            unset($_SESSION['selected_categories']);
        }


        $skin_category_array = [];
        $skin_category_array = array('Acne');
        $_SESSION['selected_categories'] = $skin_category_array;
                
        update_cart($skin_category_array); 
        
        if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
            unset($_SESSION['summary']);
            // WC()->cart->empty_cart();
        }
                
        $selected_category = 'Acne';
        $_SESSION['summary'][$selected_category] = [];
        foreach ($form_data as $section => $questions) {
            foreach($questions as $question){
                foreach($question as $que => $ans){
                    $_SESSION['summary'][$selected_category][$que] = $ans;
                
                }
            }      
        }                 
    }
    catch(Exception $e){
        error_log('Error in custom_recommended_products: ' . $e->getMessage());
    }
    
}



//selecting QNA form based on selected category 
function show_next_QNA_form(){
    try{
        if (!session_id()) {
            session_start();
        }

       
        
        if (!isset($_SESSION['selected_categories']) || !isset($_SESSION['current_form_id'])) {
            echo "No categories selected.";
            return;
        }


        $selected_categories = $_SESSION['selected_categories'];
        // $num_categories = count($selected_categories);
        $submitted_form_id =  $_SESSION['current_form_id'];


        if($submitted_form_id == hair_care){
            selecting_hair_care_QNA($selected_categories);
        }
      
        if($submitted_form_id == Performance){
            selecting_performance_QNA($selected_categories);   
        }
         

    }catch(Exception $e){
        error_log('Error in show_next_QNA_form: ' . $e->getMessage());
    }

}

function display_QNA_form(){
    show_next_QNA_form();
   
}


// updating QNA summary
function updating_QNA_summary($form_id, $form_data){
    try{

        if (!session_id()) {
            session_start();
        }

        if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
            unset($_SESSION['summary']);
            // WC()->cart->empty_cart();
        }

        
        $selected_categories;
        if(isset($_SESSION['selected_categories']) && !empty($_SESSION['selected_categories'])){

            $selected_categories = $_SESSION['selected_categories'];
        }

        

        $accessing_category;
        foreach($selected_categories as $selected_category){     
            $accessing_category = $selected_category;
        }

        // error_log($accessing_category);
        $_SESSION['current_form_id'] = $form_id;
        // error_log($form_id);
        $_SESSION['summary'][$accessing_category] = [];
       
        foreach ($form_data as $section => $questions) {
            foreach($questions as $question){
                foreach($question as $que => $ans){
                    $_SESSION['summary'][$accessing_category][$que] = $ans;
                    
                }
            }
            
        }  

    }catch(Exception $e){
        error_log('Error in upading_QNA_summary: ' . $e->getMessage());
    }
                   
}








// QNA forms based on category
function selecting_hair_care_QNA($selected_categories){
    try{
        foreach($selected_categories as $category){
            switch($category){
                case 'Receding hair line':
                    echo '<div>';
                    echo do_shortcode('[multi-step-form id="8"]');
                    echo '</div>';
                break; 
                
                case 'Bald Patches':
                    echo do_shortcode('[multi-step-form id="9"]');
                break; 
    
                case 'Thinning at top of the head':
                    echo do_shortcode('[multi-step-form id="9"]');
                break; 
    
                case 'Redness/Irritation':
                    if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
                        unset($_SESSION['summary']);
                        WC()->cart->empty_cart();
                    }

                    $_SESSION['summary'][$category] = [];

                    echo '<script>
                            window.onload = function() {
                                    window.location.href = "' . site_url('/recommended-products') . '";
        
                            };
                    </script>';
                   
                    // echo '<script>window.location.href = "' . site_url('/recommended-products') . '";</script>';
                break;
    
                default: 
                    if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
                        unset($_SESSION['summary']);
                        WC()->cart->empty_cart();
                    }
                    echo "form did not found";
                break;  
    
            } 
        }
    }catch(Exception $e){
        error_log('Error in selecting_hair_care_QNA: ' . $e->getMessage());
    }
    

}

function selecting_performance_QNA($selected_categories){
    try{
        foreach($selected_categories as $category){
            switch($category){
                case 'Erection': 
                    echo do_shortcode('[multi-step-form id="5"]');
                break;

                case 'Early Climax': 
                    echo do_shortcode('[multi-step-form id="6"]');
                break;

                case 'Infertility':

                    echo '<script>
                            window.onload = function() {
                                    window.location.href = "' . site_url('/erectile-dysfunction') . '";
        
                            };
                    </script>';
                    
                   
                    // echo '<script>window.location.href = "' . site_url('/erectile-dysfunction') . '";</script>';
                break;

                case 'Erection, Early Climax': 
                    
                    if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
                        unset($_SESSION['summary']);
                        WC()->cart->empty_cart();
                    }

                    $_SESSION['summary'][$category] = [];

                    echo '<script>
                            window.onload = function() {
                                    window.location.href = "' . site_url('/recommended-products') . '";
        
                            };
                    </script>';
                   
                    // echo '<script>window.location.href = "' . site_url('/recommended-products') . '";</script>';
                break;

                default: 
                    
                    if(isset($_SESSION['summary']) && !empty($_SESSION['summary'])){
                        unset($_SESSION['summary']);
                        WC()->cart->empty_cart();
                    }

                    $_SESSION['summary'][$category] = [];
                    
                    echo '<script>
                            window.onload = function() {
                                    window.location.href = "' . site_url('/erectile-dysfunction') . '";
        
                            };
                    </script>';
                    // echo '<script>window.location.href = "' . site_url('/erectile-dysfunction') . '";</script>';
                break;

            }
        } 

    }catch(Exception $e){
        error_log('Error in selecting_performance_QNA: ' . $e->getMessage());
    }
}