<?php
// Check if the session variable exists and has data
if (isset($_SESSION['selected_categories']) && !empty($_SESSION['selected_categories'])) {
    $selected_categories = $_SESSION['selected_categories'];
    // Output each category
    foreach ($selected_categories as $category) {
    
        retrive_products_based_on_categories($category);
       
    }

    // retrive_products_based_on_categories($selected_categories);


} else {
    echo '<div>No categories selected.</div>';
}


?>


<script>

    jQuery(document).ready(function($){
        $('.add_to_cart_form').on('submit', function(e){
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: formData + '&action=add_to_cart',
                success: function(response){
            
                    $('.btn_submit_to_cart').click(function() {
                        $(this).html('Added to cart');
                    });
                    window.location.href = '/product-added-to-the-cart'; 
                },

                error: function(xhr, status, error) {
                    // Handle errors
                    $('.btn_submit_to_cart').html('Try again later');
                }

            });

        });

    

    });
</script>