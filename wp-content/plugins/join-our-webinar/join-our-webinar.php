<?php
/*
Plugin Name:  Join Our Webinar
Plugin URI:   http://strivemindz.com
Description:  Join our webinar custom post listing click on button with open popup with contact form, after submit submit successfully with redirect on webinar url
Version:      1.0
Author:       Mangi LaL
Author URI:   http://strivemindz.com
Text Domain:  Edubin
Domain Path:  /languages
*/


function join_out_webinar() {
?>
	<script type="text/javascript">
	  jQuery(document).ready(function($) {
		    $('.webinar-btn').click(function(e) {
		    	$('#current_post').val('');	
				$('#sucess_response').html(''); // Display response in the response div
				$('#error_response').html('');
		        e.preventDefault();
		        var postURL = $(this).data('post-url');
		        var postID = $(this).data('post-id');
		        console.log('postID',postID);
		        console.log('postURL',postURL);	
		        if(postURL != ''){
		        	 $('#current_post').val(postURL);	
		        }else{
		        	$('#current_post').val('#');	
		        }
		        $('#joinourwebinar_form').modal('show');
		    });
		});
	</script>

	<!-- Contact form -->
	<div class="modal fade" id="joinourwebinar_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Do you have any questions?</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form id="contactForm">
	          <div class="mb-3">
	            <input type="text" class="form-control" id="your_name" name="your_name" required placeholder="Your Name">
	          </div>
	          <div class="mb-3">
	            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required placeholder="Mobile Number">
	          </div>
	          <div class="mb-3">
	            <input type="text" class="form-control" id="city" name="city" required placeholder="City">
	          </div>
	          <div class="mb-3">
	            <input type="email" class="form-control" id="you_email" name="you_email"  required placeholder="Your Email">
	          </div> 
	          <div class="mb-3">
	            <input type="text" class="form-control" id="language_fileld" name="language_fileld" required placeholder="Which language you want to learn?">
	          </div>
	          <div class="mb-3">
	            <input type="hidden" class="form-control" id="current_post" name="current_post" value="">
	          </div>
	          <div class="mb-3">
	            <textarea class="form-control" id="message" name="message" required placeholder="Your Message"></textarea>
	          </div>
			    <button type="submit" class="join_our_webinar_btn">Submit</button>
			</form>
			<div id="sucess_response" style="color:green"></div>
			<div id="error_response" style="color:red"></div>
	    </div>
	  </div>
	</div>
	<!-- Contact form end-->
	<!-- Include jQuery library -->
	<script>
		jQuery(document).ready(function($) {
		    jQuery('#contactForm').submit(function(e) {
		        e.preventDefault();
		        
		        // Validate form inputs
		        var valid = true;
		        jQuery('#contactForm input, #contactForm textarea').each(function() {
		            if (!jQuery(this).val()) {
		                valid = false;
		                jQuery(this).addClass('error');
		            } else {
		                jQuery(this).removeClass('error');
		            }
		        });

		        if (!valid) {
		            jQuery('#response').text('Please fill out all required fields.');
		            return;
		        }
		        var current_redirect_url = jQuery("#current_post").val();
		        // Serialize form data
		        var formData = jQuery(this).serialize();
		         $.ajax({
		            type: 'POST',
		            dataType: 'JSON',
		            url:  "<?php echo admin_url('admin-ajax.php')?>",
		            data: {
		                action: 'submit_our_webinar_form',
		                data :{ 
		                	    your_name: jQuery('#your_name').val(),
		                	    mobile_number: jQuery('#mobile_number').val(),
		                	    city: jQuery('#city').val(),
		                	    you_email: jQuery('#you_email').val(),
		                	    language_fileld: jQuery('#language_fileld').val(),
		                	    message: jQuery('#message').val(),
		                	},
		            },
		            beforeSend:function(){
	                   jQuery('.join_our_webinar_btn').html("Submitting....");
	                },
		            success: function(response) {
		            	jQuery('.join_our_webinar_btn').html("Submit");
		            	if(response.status == 200){
		            		$('#sucess_response').html(response.message); // Display response in the response div
		            		if(current_redirect_url != '' & current_redirect_url != "#"){
		            			window.location.href = current_redirect_url;
		            		}
		            		$('#contactForm')[0].reset();
		            	}else{
		            		$('#error_response').html(response.message); // Display response in the response div
		            	}
		            }
		        });
		    });
		});
	</script>

<?php
}

add_action( 'wp_footer', 'join_out_webinar' );

function submit_our_webinar_form() {

    $enqueryData = $_POST['data'];
    $Message = $enqueryData['message'];
    $Email = $enqueryData['you_email'];
    $Name = $enqueryData['your_name'];
    $MobileNo = $enqueryData['mobile_number'];
    $City = $enqueryData['city'];
    $LanguageFileld = $enqueryData['language_fileld'];
	$to = get_option( 'admin_email' ); // Replace with the recipient's email address
	$subject = 'Enquiry : Join Our Webinar';
	 $headers = array(
	    'From: ' . $enqueryData['your_name'] . ' <' . $enqueryData['you_email'] . '>',
	    'Content-Type: text/html; charset=UTF-8',
	);
	$message_content = "
	                Name: $Name<br>
	                Email: $Email<br>
	                Mobile No: $MobileNo<br>
	                City: $City<br>
	                Language Learn: $LanguageFileld<br>
	                Message: $Message";
	$email_sent = wp_mail($to, $subject, $message_content, $headers);
	$response = array();
	if ($email_sent) {
		 $response = array(
            'status' => 200,
            'message' => 'Email sent successfully!'
        );
		 echo json_encode($response);
	} else {
		$response = array(
            'status' => 400,
            'message' => 'Failed to send email. Please try again.'
        );
		echo json_encode($response);
	} 	
   wp_die();
}
add_action('wp_ajax_submit_our_webinar_form', 'submit_our_webinar_form');
add_action('wp_ajax_nopriv_submit_our_webinar_form', 'submit_our_webinar_form');


