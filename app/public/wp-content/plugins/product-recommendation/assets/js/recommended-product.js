


jQuery(document).ready(function($) {
    // Change button text to "Next"
    $('.fw-btn-submit').text('Next');
    $(document).on('click', '.fw-btn-submit', function(event) {
        event.preventDefault();
        
        $(this).text('Next');
        $(this).prop('disabled', true);
        
    });

    $('.fw-button-next').text('Next');

    $('.fw-button-previous').text('Back');

    $('#multi-step-form .fw-alert-user').css("visibility", "hidden");

    $('#multi-step-form  .fa.form-control-feedback').hide();



    // hair care option images

    $('<img class="hair_care_image" src="/wp-content/uploads/2024/03/Receding-hair-line.png" alt="Receding Hairline Image"/>').insertBefore('div[data-wizardid="7"] input[id="fw-7-0-0-0-1"]');
    $('<img class="hair_care_image" src="/wp-content/uploads/2024/03/Thinning-at-top-of-the-head.png" alt="Thinning at top of the head"/>').insertBefore('div[data-wizardid="7"] input[id="fw-7-0-0-0-2"]');
    $('<img class="hair_care_image" src="/wp-content/uploads/2024/03/Bald-Patches.png" alt="Bald Patches"/>').insertBefore('div[data-wizardid="7"] input[id="fw-7-0-0-0-3"]');
    $('<img class="hair_care_image" src="/wp-content/uploads/2024/03/R-I-3.png" alt="Redness/Irritation"/>').insertBefore('div[data-wizardid="7"] input[id="fw-7-0-0-0-4"]');
   
    $('.fw-choice img').on('click', function() {
        $(this).siblings('input[type="radio"]').prop('checked', true).trigger('change');
    });
   
    $('.fw-btn-submit').attr('id', 'custom_submit_btn');

    


    // recommended product page add to cart button
    $(document).on('mouseenter', '.btn_submit_to_cart', function() {
        $(this).css({
            "background-color":  "#FFDA6A",
            "color": "#242424",
        });
    }).on('mouseleave', '.btn_submit_to_cart', function() {
        $(this).css({
            "background-color":  "#FFDA6A",
            "color": "#242424",
        });
    }).on('click', '.btn_submit_to_cart', function() {
        $(this).html('Added to cart');
        $(this).css({
            "background-color":  "#FFDA6A",
            "color": "#242424",
        });
    });



    // text box apprear and disappear in the qna form
    $('#multi-step-form label[for="msf-text-please-specify-symptoms"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-symptoms"]').attr('placeholder', 'Please specify symtoms here');
    $('#multi-step-form input[id="msf-text-please-specify-symptoms"]').parent().css('display','none');
    $('#multi-step-form input[id="msf-text-please-specify-symptoms"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-conditions"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-conditions"]').attr('placeholder', 'Please specify conditions here');
    $('#multi-step-form input[id="msf-text-please-specify-conditions"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-conditions"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-medication"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-medication"]').attr('placeholder', 'Please specify medication here');
    $('#multi-step-form input[id="msf-text-please-specify-medication"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-medication"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-medical-conditions"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-medical-conditions"]').attr('placeholder', 'Please specify medical conditions');
    $('#multi-step-form input[id="msf-text-please-specify-medical-conditions"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-medical-conditions"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-allergies"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-allergies"]').attr('placeholder', 'Please specify allergies here');
    $('#multi-step-form input[id="msf-text-please-specify-allergies"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-allergies"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-hospitalizations-or-surgeries"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-hospitalizations-or-surgeries"]').attr('placeholder', 'Please specify hospitalizations here');
    $('#multi-step-form input[id="msf-text-please-specify-hospitalizations-or-surgeries"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-hospitalizations-or-surgeries"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-medicines-here"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-medicines-here"]').attr('placeholder', 'Please specify medicines here');
    $('#multi-step-form input[id="msf-text-please-specify-medicines-here"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-medicines-here"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-heart-medication"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-heart-medication"]').attr('placeholder', 'Please specify heart medication here');
    $('#multi-step-form input[id="msf-text-please-specify-heart-medication"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-heart-medication"]').addClass('QNA_text_fields');

    $('#multi-step-form label[for="msf-text-please-specify-liver-disease"]').hide();
    $('#multi-step-form input[id="msf-text-please-specify-liver-disease"]').attr('placeholder', 'Please specify liver disease here');
    $('#multi-step-form input[id="msf-text-please-specify-liver-disease"]').parent().css('display', 'none');
    $('#multi-step-form input[id="msf-text-please-specify-liver-disease"]').addClass('QNA_text_fields');


    $(document).on('click', '#fw-8-0-0-2-1, #fw-9-0-0-2-1', function() {
        $('#msf-text-please-specify-symptoms').parent().show(200);
    }).on('click', '#fw-8-0-0-2-2, #fw-9-0-0-2-2', function() {
        $('#msf-text-please-specify-symptoms').parent().hide(200);
    }).on('click', '#fw-8-0-0-4-1, #fw-9-0-0-4-1', function() {
        $('#msf-text-please-specify-conditions').parent().show(200);
    }).on('click', '#fw-8-0-0-4-2, #fw-9-0-0-4-2', function() {
        $('#msf-text-please-specify-conditions').parent().hide(200);
    }).on('click', '#fw-8-1-0-1-1, #fw-9-1-0-1-1', function() {
        $('#msf-text-please-specify-medication').parent().show(200);
    }).on('click', '#fw-8-1-0-1-2, #fw-9-1-0-1-2', function() {
        $('#msf-text-please-specify-medication').parent().hide(200);
    }).on('click', '#fw-8-1-0-3-1, #fw-9-1-0-3-1', function() {
        $('#msf-text-please-specify-medical-conditions').parent().show(200);
    }).on('click', '#fw-8-1-0-3-2, #fw-9-1-0-3-2', function() {
        $('#msf-text-please-specify-medical-conditions').parent().hide(200);
    }).on('click', '#fw-8-1-0-5-1, #fw-9-1-0-5-1, #fw-5-1-0-5-1', function() {
        $('#msf-text-please-specify-allergies').parent().show(200);
    }).on('click', '#fw-8-1-0-5-2, #fw-9-1-0-5-2, #fw-5-1-0-5-2', function() {
        $('#msf-text-please-specify-allergies').parent().hide(200);
    }).on('click', '#fw-8-1-0-7-1, #fw-9-1-0-7-1', function() {
        $('#msf-text-please-specify-hospitalizations-or-surgeries').parent().show(200);
    }).on('click', '#fw-8-1-0-7-2, #fw-9-1-0-7-2', function() {
        $('#msf-text-please-specify-hospitalizations-or-surgeries').parent().hide(200);
    }).on('click', '#fw-5-1-0-1-1, #fw-6-0-0-1-1', function() {
        $('#msf-text-please-specify-heart-medication').parent().show(200);
    }).on('click', '#fw-5-1-0-1-2, #fw-6-0-0-1-2', function() {
        $('#msf-text-please-specify-heart-medication').parent().hide(200);
    }).on('click', '#fw-5-1-0-3-1, #fw-6-0-0-6-1', function() {
        $('#msf-text-please-specify-medicines-here').parent().show(200);
    }).on('click', '#fw-5-1-0-3-2, #fw-6-0-0-6-2', function() {
        $('#msf-text-please-specify-medicines-here').parent().hide(200);
    }).on('click', '#fw-6-0-0-3-1', function() {
        $('#msf-text-please-specify-liver-disease').parent().show(200);
    }).on('click', '#fw-6-0-0-3-2', function() {
        $('#msf-text-please-specify-liver-disease').parent().hide(200);
    });
    
});
