var admin_option_error = 'none';
var admin_option_error_message = '';

function check_user_register_rating_setting(allow_rating_val){
	if(2 != allow_rating_val){
    	jQuery('#post_ratings_ristric_to option.aio-rating-user').removeAttr("selected");
    	jQuery('#post_ratings_ristric_to option.aio-rating-user').hide();
    	jQuery('#post_ratings_ristric_to option[value=2]').attr('selected','selected');
    }else{
    	jQuery('#post_ratings_ristric_to option.aio-rating-user').show();
    }
}

function minmax(value, min, max) {
    if(parseInt(value) < min || isNaN(value)) 
        return min; 
    else if(parseInt(value) > max) 
        return 100; 
    else return value;
}

jQuery(document).ready(function($) {
	
	// if admin will selected Rating Restriction on days
		
	$('#post_ratings_ristric_to').on('change', 'select', function(){
        if(3 == this.value){
            $('#post_rating_restric_day').show();
        }else{
        	$('#post_rating_restric_day').hide();
        }
    });
    
    // page load time check user register method
    check_user_register_rating_setting($("#postratings_allow_to option:selected").val());
    
    // select allow to register method change time check method    
    $(document).on('change', 'select#postratings_allow_to', function(){
        check_user_register_rating_setting(this.value);
    });    
    
    
    
    // Save post rating option value with ajax call
	
	$('p.submit .btn-submit').click(function(){
		// This does the ajax request
		$('.post-rating_notification').hide();
		admin_option_error = 'none';
		$('#rating_option_wrapper #post-rating-loader').show();
		var rating_img_name = $('input[name=postratings_image]:checked').val();
		
		var google_rich = $('input[name=google_rich]:checked').val();
		var total_rating = $('input[name=no_of_rating]').val();
		//custom rating img
		
		var rating_none = $('#rating_none').val();
		var rating_full = $('#rating_full').val();
		var rating_avg = $('#rating_avg').val();
		var rating_hover = $('#rating_hover').val();
		
		
		
		var postratings_allow_to = $("#postratings_allow_to option:selected").val();
		var postratings_user_type = $("#post_ratings_ristric_type option:selected").val();
		var rating_restric_day = $("#post_rating_restric_day").val();
		
		var aio_rating_loader = $("#aio_rating_loader").val();		
		var AOI_custom_css = $("#AOI_custom_css").val();
		
		if(2 != postratings_allow_to && 1 == postratings_user_type){
			admin_option_error = 'on';
			admin_option_error_message ='Guest user will not restriction to user. Please select other option to Rating Restriction!';
		}
		if('custom' == rating_img_name){
			if ( rating_none.length <= 0 || rating_full.length <= 0 || rating_avg.length <= 0 || rating_hover.length <= 0 ) {
				admin_option_error = 'on';
				admin_option_error_message ='Please select all Rating images!';
			}
		}
		
		
		if('on' == admin_option_error){
			$('.post-rating_notification').show();
		    $('.post-rating_notification').html('<div class="error"><p>'+admin_option_error_message+'</p></div>');
		    $('#rating_option_wrapper #post-rating-loader').hide();
		}else{				
		    $.ajax({
		        url: ajaxurl,
		        type:'POST',
		        data: {
		            'action'				:	'rating_option_ajax',
		            'rating_img_name' 		:	rating_img_name,
		            'google_rich' 	  		:	google_rich,
		            'total_rating'	  		:	total_rating,
		            'postratings_allow_to' 	:	postratings_allow_to ,
		            'postratings_user_type'	: 	postratings_user_type,
		            'rating_restric_day'	:	rating_restric_day,
		            'rating_none'			: 	rating_none,
		            'rating_full' 			:	rating_full,
		            'rating_avg' 			:	rating_avg,
		            'rating_hover'			:	rating_hover,
		            'AOI_custom_css'		:	AOI_custom_css,
		            'aio_rating_loader'		:	aio_rating_loader
		        },
		        success:function(data) {
		            if('sucess' == data){
		            	$('.post-rating_notification').show();
		            	$('.post-rating_notification').html('<div class="updated"><p>Updated sucessfully!</p></div>');
		            	window.setTimeout(function(){location.reload()},1000);
		            }else{
		            console.log(data);
		            }
		            $('#rating_option_wrapper #post-rating-loader').hide();	            
		        }
		        
		    });
		}
		$('html,body').animate({scrollTop: 0 }, 700);
		 
    return false;
	});
	
	setTimeout(function() { $('.post-rating_notification').hide('fast');}, 1000); 
	
	$("input[name=postratings_image]:radio").change(function () {
		
        if('custom' == this.value){
            $('tr.csutom_rating_img').show();
        }else{
        	$('tr.csutom_rating_img').hide();
        }
    });
    var custom_uploader;
    var current;
	
	$('.custom_image_url_upload').click(function(e) {
		current = $(this);
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            current.val(attachment.url);
            current.closest('div.custom-img-uploding-wrapper').find('span.example-img img').attr('src',attachment.url)
        });
        
        custom_uploader.open();
    }); 

    // AIO display rating Template 
    $('p.submit .aio-btn-submit-for-display').click(function(e){
    	e.preventDefault();        
    	$('.post-rating_notification').hide();
		$('#rating_option_wrapper #post-rating-loader').show();
		
		var AOI_postratings_none_template = $('#AOI_postratings_none_template').val();
		var AOI_all_ready_rate_template = $('#AOI_all_ready_rate_template').val();
		var AOI_after_user_rating_template = $('#AOI_after_user_rating_template').val();
		
    	$.ajax({
	        url: ajaxurl,
	        type:'POST',
	        data: {
	            'action'								:	'rating_display_template_ajax_request',
	            'AOI_postratings_none_template' 		:	AOI_postratings_none_template,
	            'AOI_all_ready_rate_template' 	  		:	AOI_all_ready_rate_template,
	            'AOI_after_user_rating_template'		:	AOI_after_user_rating_template,
	            
	        },
	        success:function(data) {                     
	            if('sucess' == data){
	            	$('.post-rating_notification').show();
	            	$('.post-rating_notification').html('<div class="updated"><p>Updated sucessfully!</p></div>');
	            	window.setTimeout(function(){location.reload()},1000);
	            }else{
	            console.log(data);
	            }
	            $('html,body').animate({scrollTop: 0 }, 700);
	            $('#rating_option_wrapper #post-rating-loader').hide();	            
	        }
	        
	    });
	    return false;
    });

    
    
    // Loader default value
    $('.custom-img-uploding-wrapper span.default-loader').click(function(){
    	$('.custom-img-uploding-wrapper #aio_rating_loader').val('');
    });
	
    //only number validation
    $(".num-error-val").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(this).closest('td').find("#num-error-msg").html("Number Only").show().fadeOut("slow");
               return false;
    }
   });
   
   // default-template set on admin
   
   // AIO display rating Template 
    $('a#default-template').click(function(){    	  
    	$('.post-rating_notification').hide();
		$('#rating_option_wrapper #post-rating-loader').show();
		var admin_confirm = confirm('Are you sure you want to save All default template.?');
		if ( admin_confirm == true ){
			
    	$.ajax({
	        url: ajaxurl,
	        type:'POST',
	        data: {
	            'action':'rating_display_default_template',
	            'AOI_default_template':'default-template',
	            
	            
	        },
	        success:function(data) {                     
	            if('sucess' == data){
	            	$('.post-rating_notification').show();
	            	$('.post-rating_notification').html('<div class="updated"><p>Default Updated sucessfully!</p></div>');
	            	window.setTimeout(function(){window.location.reload();},1000);
	            }else{
	            console.log(data);
	            }
	            $('html,body').animate({scrollTop: 0 }, 700);
	            $('#rating_option_wrapper #post-rating-loader').hide();	            
	        }
	        
	    });
	    }
	    return false;
    });
    
    if( $('.custom-img-uploding-wrapper #aio_rating_loader').val() != "" ){    
    	$('.custom-img-uploding-wrapper span.default-loader').css('display','inline-block');
    }
    
  
    // subscription dialog box script 
    
    	$( "#ctr_dialog" ).dialog({ 
		modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
		width: '500', resizable: false,
		position: {my: "center", at:"center", of: window },
		dialogClass: 'dialogButtons',
		buttons: {
			Yes: function () {
				// $(obj).removeAttr('onclick');
				// $(obj).parents('.Parent').remove();
				var email_id = $('#txt_user_sub_ctr').val();

				var data = {
				'action': 'add_plugin_user_ctr',
				'email_id': email_id
				};

				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
				jQuery.post(ajaxurl, data, function(response) {
					$('#ctr_dialog').html('<h2>You have been successfully subscribed');
					$(".ui-dialog-buttonpane").remove();
				});

				
			},
			No: function () {
				var email_id = $('#txt_user_sub_ctr').val();

				var data = {
				'action': 'hide_subscribe_ctr',
				'email_id': email_id
				};

				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
				$.post(ajaxurl, data, function(response) {
					        					 
				});
				
				$(this).dialog("close");
				
			}
		},
		close: function (event, ui) {
			$(this).remove();
		}
	});

	$("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
    $("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
	
    
});