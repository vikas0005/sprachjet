jQuery(document).ready(function($){
    
    
    const imagePreview = $('.pencard_img');
    
    $("input[name='pancardfie']").on("change", function() {
        const file = this.files[0];
        //console.log(file);
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            console.log(event.target.result);
            $('.pencard_img').attr('src', event.target.result);
            
          }
          reader.readAsDataURL(file);
        }
    });
    $("input[name='adharcardfile']").on("change", function() {
        const file = this.files[0];
        //console.log(file);
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            console.log(event.target.result);
            $('.adharcard_img').attr('src', event.target.result);
            
          }
          reader.readAsDataURL(file);
        }
    });
    $("input[name='profilepic']").on("change", function() {
        const file = this.files[0];
        //console.log(file);
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            console.log(event.target.result);
            $('#partner_img img').attr('src', event.target.result);
            
          }
          reader.readAsDataURL(file);
        }
    });
    
    var href = window.location.href;
    if(href.indexOf('/partner-dashboard/') > -1){
        const input = document.querySelector("input[name='phone_no']");
        window.intlTelInput(input,({
        }));
    }
    

    // let table = new DataTable('#all_list_std');
    let table = new DataTable('#all_list_std', {
            order: [[2, 'asc']],
            columnDefs: [
                { targets: 2, searchable: true } // Enable searching for the "Application Status" column (index 2)
            ],
            colReorder: true
        });
    
    
    let table2 = new DataTable('#all_student_list', {
            order: [[2, 'asc']]
        });
    let table3 = new DataTable('#lead_student_list', {
        order: [[2, 'asc']]
    });

    $('input[name="phone_no"], input[name="mailing_pincode"], input[name="account_number"], input[name="adharcard"], input[name="pancard"], input[name="zipcode"]').keypress(function(event) {
        // Get the ASCII value of the pressed key
        var charCode = (event.which) ? event.which : event.keyCode;

        // Allow only numbers (ASCII: 48-57), backspace (ASCII: 8), and delete (ASCII: 46)
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 8 && charCode != 46) {
            // Prevent the default action (typing the character)
            event.preventDefault();
        }
    });
    
    var partner_sts = $("#partner_sts_value").val();
    var partner_city_value = $("#partner_city_value").val();

    //alert(partner_sts);\
    if(partner_sts != '' ) {
        $("#partner_sts").val(partner_sts);
        $("#partner_sts").trigger("onchange")
        $("#city_value").val(partner_city_value);

    }

    $(".login-register .dropdown").on("click", function(){
        $(this).find(".dropdown-menu").toggleClass("active");
    });
    
    $('#create-student').submit(function(e) {
      e.preventDefault();

      var valid = true;
      var remark = $(this).find("#addremark").val();
      
      // First Name validation
      var firstName = $(this).find('#first_name').val();
      if (firstName.trim() == '') {
        $('.first_name-msg').text('First Name is required');
        valid = false;
      } else {
        $('.first_name-msg').text('');
      }

      // Last Name validation
      var lastName = $(this).find('#last_name').val();
      if (lastName.trim() == '') {
        $('.last_name-msg').text('Last Name is required');
        valid = false;
      } else {
        $('.last_name-msg').text('');
      }

      // Gender validation
      var gender = $(this).find('#gender').val();
      if (gender.trim() == '') {
        $('.gender-msg').text('Gender is required');
        valid = false;
      } else {
        $('.gender-msg').text('');
      }

      // Email validation
      var email = $(this).find('#email').val();
    //   if (email.trim() == '') {
    //     $('.email-msg').text('Email is required');
    //     valid = false;
    //   } else {
    //     $('.email-msg').text('');
    //   }
      
       // Email validation
      var phone_no = $(this).find('#phone_no').val();
      if (phone_no == '') {
        $('.phone-msg').text('Phone no. is required');
        valid = false;
      } else {
        $('.phone-msg').text('');
      }

      // State validation
      var state = $(this).find('#sts').val();
      if (state.trim() == '') {
        $('.StateList-msg').text('State is required');
        valid = false;
      } else {
        $('.StateList-msg').text('');
      }

      // City validation
      var city = $(this).find('#state').val();
      if (city == '' || city == null) {
        $('.CityList-msg').text('City is required');
        valid = false;
      } else {
        $('.CityList-msg').text('');
      }

      // Zip Code validation
      var zipCode = $(this).find('#mailing_pincode').val();
      if (zipCode.trim() == '') {
        $('.mailing_pincode-msg').text('Zip Code is required');
        valid = false;
      } else {
        $('.mailing_pincode-msg').text('');
      }

    // Priority validation
    var priority = $(this).find('select[name="priority"]').val();
    if (priority.trim() == '') {
        $('.mailing_priority-msg').text('Priority is required');
        valid = false;
    }
    else {
        $('.mailing_priority-msg').text('');
    }

      if (valid) {
        // If all validations pass, you can submit the form
        //this.submit();
        var data = {
            action: 'add_partner_students',
            firstName: firstName,
            lastName: lastName,
            gender: gender,
            phone_no: phone_no,
            email: email,
            state: state,
            city: city,
            zipCode: zipCode,
            remark: remark,
            priority: priority,
            application_status: 'Pending'
        }
        ajax_student(data);
      }
    });
  
    $(".refer_std").on("click", function(){
        $(".student_frm_sec").addClass("showfrm");
    });
    
    $("#v-pills-tab button").on("click", function(){
        jQuery(".student_frm_sec").removeClass("showfrm");
    });
    
    $("#state_value").on("click", function(){
         $("#sts").click();
    });
    
    
    $("#partner-profile-edit").on("submit", function(e){
        e.preventDefault();
        
        var first_name = $("#pfirst_name").val();
        var last_name = $("#plast_name").val();
        var pemail = $("#pemail").val();
        var pmobile = $("#pmobile").val();
        var address = $("#address").val();
        var pstate = $("#partner_sts").val();
        var pcity = $("#city_value").val();
        var zipcode = $("#zipcode").val();
        var landmark = $("#landmark").val();
        var account_number = $("#account_number").val();
        var bankname = $("#Bankname").val();
        var branchname = $("#branchname").val();
        var ifsc_code = $("#ifsc_code").val();
        var pancard_no = $("#pancard").val();
        var adharcard_no = $("#adharcard").val();
    
        var valid = true;

        // First Name validation
        if (first_name.trim() == '') {
        $('.pfirst_name-msg').text('First Name is required');
        valid = false;
        } else {
        $('.pfirst_name-msg').text('');
        }

        // Last Name validation
        if (last_name.trim() == '') {
        $('.plast_name-msg').text('Last Name is required');
        valid = false;
        } else {
        $('.plast_name-msg').text('');
        }

        // Email validation
        if (pemail.trim() == '') {
        $('.pemail-msg').text('Email is required');
            valid = false;
        } else {
            $('.pemail-msg').text('');
        }
      
        // Email validation
        if (pmobile == '') {
            $('.pphone-msg').text('Phone no. is required');
            valid = false;
        } else {
            $('.pphone-msg').text('');
        }
        
        // Account Number validation
        if (account_number.trim() == '') {
            $('.account_number-msg').text('Account Number is required');
            valid = false;
        } else {
            $('.account_number-msg').text('');
        }

        // bankname  validation
        if (bankname.trim() == '') {
            $('.bankname-msg').text('Bank name is required');
        valid = false;
        } else {
            $('.bankname-msg').text('');
        }

      // branchname validation
        if (branchname.trim() == '') {
            $('.branchname-msg').text('Branch name is required');
        valid = false;
        } else {
            $('.branchname-msg').text('');
        }
      
        // Email validation
        if (ifsc_code == '') {
            $('.ifsc_code-msg').text('IFSC code is required');
        valid = false;
        } else {
            $('.ifsc_code-msg').text('');
        }
        
        if ($('#pancardfie').val() != '') {
            var file = $('#pancardfie')[0].files[0];
            var fileSize = file.size; // in bytes
            var maxSize = 1048576; // 1 MB
    
            // Check file size
            if (fileSize > maxSize) {
                $('.pancardfie-msg').text('File size exceeds 1 MB limit.');
                $('#pancardfie').val('');
                valid = false;
            }else {
            $('.pancardfie-msg').text('');
            }
    
            // Check file type
            var fileType = file.type;
            var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

            if (allowedTypes.indexOf(fileType) === -1) {
                $('.pancardfie-msg').text('File type not allowed. Please upload JPEG, PNG, PDF, or DOCX files.');
                $('#pancardfie').val('');
                valid = false;
            } else {
                $('.pancardfie-msg').text('');
            }
        }
        if ($('#adharcardfile').val() != '') {
            var file = $('#adharcardfile')[0].files[0];
            var fileSize = file.size; // in bytes
            var maxSize = 1048576; // 1 MB
    
            // Check file size
            if (fileSize > maxSize) {
                $('.adharcardfile-msg').text('File size exceeds 1 MB limit.');
                $('#adharcardfile').val('');
                valid = false;
            }else {
            $('.adharcardfile-msg').text('');
            }
    
            // Check file type
            var fileType = file.type;
            var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

            if (allowedTypes.indexOf(fileType) === -1) {
                $('.adharcardfile-msg').text('File type not allowed. Please upload JPEG, PNG, PDF, or DOCX files.');
                $('#adharcardfile').val('');
                valid = false;
            } else {
                $('.adharcardfile-msg').text('');
            }
        }
        if ($('#profilepic').val() != '') {
            var file = $('#profilepic')[0].files[0];
            var fileSize = file.size; // in bytes
            var maxSize = 1048576; // 1 MB
    
            // Check file size
            if (fileSize > maxSize) {
                $('.profile-msg-msg').text('File size exceeds 1 MB limit.');
                $('#profilepic').val('');
                valid = false;
            }else {
            $('.profile-msg').text('');
            }
    
            // Check file type
            var fileType = file.type;
            var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

            if (allowedTypes.indexOf(fileType) === -1) {
                $('.profile-msg').text('File type not allowed. Please upload JPEG, PNG, PDF, or DOCX files.');
                $('#profilepic').val('');
                valid = false;
            } else {
                $('.profile-msg').text('');
            }
        }

        if(valid) {
            var allFilesData = new FormData();
        
            // Add non-file data to formData
            allFilesData.append('action', 'edit_partner_profile');
            allFilesData.append('address', address);
            allFilesData.append('state', pstate);
            allFilesData.append('city', pcity);
            allFilesData.append('zipcode', zipcode);
            allFilesData.append('landmark', landmark);
            allFilesData.append('account_number', account_number);
            allFilesData.append('bankname', bankname);
            allFilesData.append('branchname', branchname);
            allFilesData.append('ifsc_code', ifsc_code);
            allFilesData.append('pancard_no', pancard_no);
            allFilesData.append('adharcard_no', adharcard_no);
        
            allFilesData.append('first_name', first_name);
            allFilesData.append('last_name', last_name);
            allFilesData.append('pemail', pemail);
            allFilesData.append('pmobile', pmobile);
        
             // Add file inputs to formData
            var pancardFile = $("input[name='pancardfie']")[0].files[0];
            var adharcardFile = $("input[name='adharcardfile']")[0].files[0];
            allFilesData.append('pancardfie', pancardFile);
            allFilesData.append('adharcardfile', adharcardFile);
            var profilepic = $("input[name='profilepic']")[0].files[0];
            allFilesData.append('profilepic', profilepic);
            
            // Send data via AJAX
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: allFilesData,
                processData: false,
                contentType: false,
                beforeSend: function(msg){
                    jQuery("#preloader_two").css("display", "block");
                },
                success: function(response) {
                    console.log(response);
                    $("#partner-details").html(response);
                    jQuery(".notification_container").css("display", "block");
                    jQuery(".notification_container").html("<p>Partner updated successfully</p>");
                    jQuery("#preloader_two").css("display", "none");
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".main-dasbord-wrapper").offset().top-100
                    }, 1000);
                    
                    setTimeout(function(){
                        jQuery(".notification_container").html("");
                        jQuery(".notification_container").css("display", "none");
                    }, 5000);
                },
                error: function(xhr){
                    console.log("Error: " + xhr.responseCode);
                }  
            });
        }
        else{
            jQuery('html, body').animate({
                        scrollTop: jQuery(".main-dasbord-wrapper").offset().top-100
                    }, 1000);
        }
    });

    $(".edit_partner_profile").on("click", function(){
        $("#profilepic").trigger("click");
    });
    
    $(".change_status").on("change", function(){
        var status = $(this).val();
        // Get the parent tr element (the row)
        var row = $(this).closest("tr");
        
        // Find td elements with the specific class within the same row
        var leardId = [];
        row.find("td.std-id").each(function() {
            // Push the text content of each td to the tdValues array
            leardId.push($(this).text().trim());
        });
        
        $(".quick_update_status").trigger("click");
        $("#confirmYes").attr({
            "data-id": leardId,
            "app_status": status
        });
        
        
    });
    
    $("#confirmYes").on("click", function(event, value){
        var data = {
            action: 'update_student_status',
            stdid: $(this).attr('data-id'),
            application_status: $(this).attr('app_status')
        }
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            beforeSend: function(msg){
    	        $("#preloader_two").css("display", "block");
    	    },
            success: function(response) {
            	console.log(response);
            	$("#preloader_two").css("display", "none");
            	
            	$(".notification_container").css("display", "block");
            	$(".notification_container").html("<p>Student application status updated successfully</p>");
            	$("#confirmationModal").find(".btn-close").trigger("click");
            	$('html, body').animate({
                    scrollTop: jQuery(".main-dasbord-wrapper").offset().top-100
                }, 800);

                setTimeout(function(){
                    $(".notification_container").css("display", "none");
                    $(".notification_container").html("");
                    window.location.reload();

                }, 2000);
    
            },
            error: function(xhr){
                console.log("Error: " + xhr.responseCode);
            }  
        });
    });
    
    $("#confirmNo").on("click", function(event, value){
        $("#confirmationModal").find(".btn-close").trigger("click");
    });
    
    $(".view_action").on("click", function(){
        $(".std_view_more").trigger("click");
        var data = {
            action: 'all_student_details',
            stdid: $(this).attr('data-id')
        }
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            beforeSend: function(msg){
    	        //$("#preloader_two").css("display", "block");
    	    },
            success: function(response) {
            	console.log(response);
            	//$("#preloader_two").css("display", "none");
            	
                $("#viewmoreModal").find(".main_content").html(response);
    
            },
            error: function(xhr){
                console.log("Error: " + xhr.responseCode);
            }  
        });
    });
    
    $(".edit_state").on("focus", function(){
        //alert("in");
        var value = $(this).val();
        $(this).siblings("#sts").val(value).trigger("change");
        //$(this).siblings("#sts").click();
    })
    $(".edit_action").on("click", function(){
        
        var currentmodel = $(this).attr("data-bs-target");
        console.log(currentmodel);
        
        var std_id = $(this).attr('data-id');
        console.log(std_id);
        
        var valueState = $(currentmodel+' .edit_state').val();
        var valueCity = $(currentmodel+' .edit_city').val();
        var phone_no = 'phone_no'+std_id;
        
        const input = document.querySelector("input[name="+phone_no+"]");
        window.intlTelInput(input,({
        }));
        
        $(currentmodel).find('.edit_state').siblings("#sts"+std_id).find('option[value="' + valueState + '"]').prop('selected', true);
        
        $(currentmodel).find('.edit_state').siblings("#sts"+std_id).val(valueState).trigger("change");
        $(currentmodel).find('.edit_city').siblings("#state"+std_id).val(valueCity).trigger("change");
        
        // setTimeout(function(){
        //     $(currentmodel).find('.edit_city').siblings("#state"+std_id).find('option[value="' + value + '"]').prop('selected', true);
        // }, 3000);
        
    });

    $(".pay_action").on("click", function(){
        //alert("in");
        var currentModel = $(this).attr("data-bs-target");
        var stdId = $(this).attr("data-id");
        var exp_amt = $(this).attr("expected-amt");
        var paid_amt = $(this).attr("paid-amt");
        
        jQuery('#payment-student')[0].reset();
        $(".pay_actionbtn").trigger("click");
        $("#payment-student").find("input[name='std_id']").val(stdId);
        $("#payment-student").find("input[name='paid_amt']").val(paid_amt);
        $("#payment-student").find("input[name='expected_amount']").val(exp_amt);
        $("#payment-student").find(".payable_amount-msg").text("");
    });

    $('.edit-student').submit(function() {
     

      const currentfrm = $(this).attr("data-id");
     
      var valid = true;
      var remark = $(this).find("input[name='remark']").text();
      
      // First Name validation
      var firstName = $('#first_name'+currentfrm).val();
      if (firstName.trim() == '') {
        $('.first_name-msg'+currentfrm).text('First Name is required');
        valid = false;
      } else {
        $('.first_name-msg'+currentfrm).text('');
      }

      // Last Name validation
      var lastName = $('#last_name'+currentfrm).val();
      if (lastName.trim() == '') {
        $('.last_name-msg'+currentfrm).text('Last Name is required');
        valid = false;
      } else {
        $('.last_name-msg'+currentfrm).text('');
      }

      // Gender validation
      var gender = $('#gender'+currentfrm).val();
      if (gender.trim() == '') {
        $('.gender-msg'+currentfrm).text('Gender is required');
        valid = false;
      } else {
        $('.gender-msg'+currentfrm).text('');
      }

      // Email validation
      var email = $('#email'+currentfrm).val();

      
       // Email validation
      var phone_no = $('#phone_no'+currentfrm).val();
      if (phone_no == '') {
        $('.phone-msg'+currentfrm).text('Phone no. is required');
        valid = false;
      } else {
        $('.phone-msg'+currentfrm).text('');
      }

      // State validation
      var state = $('#sts'+currentfrm).val();
      if (state.trim() == '') {
        $('.StateList-msg'+currentfrm).text('State is required');
        valid = false;
      } else {
        $('.StateList-msg'+currentfrm).text('');
      }

      // City validation
      var city = $('#state'+currentfrm).val();
      if (city == '' || city == null) {
        $('.CityList-msg'+currentfrm).text('City is required');
        valid = false;
      } else {
        $('.CityList-msg'+currentfrm).text('');
      }

      // Zip Code validation
      var zipCode = $('#mailing_pincode'+currentfrm).val();
      if (zipCode.trim() == '') {
        $('.mailing_pincode-msg'+currentfrm).text('Zip Code is required');
        valid = false;
      } else {
        $('.mailing_pincode-msg'+currentfrm).text('');
      }

    // Priority validation
    var priority = $('#referfor'+currentfrm).val();
    if (priority.trim() == '') {
        $('.mailing_priority-msg'+currentfrm).text('Priority is required');
        valid = false;
    }
    else {
        $('.mailing_priority-msg'+currentfrm).text('');
    }

      if (valid) {
        return valid;
      }
      else{
          return valid;
      }
    });
    
    
    $("#payment-student").find("#payable_amount").on("input", function(){
        // Remove non-numeric characters from the input value
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        // Update the input value with the sanitized value
        $(this).val(sanitized);
        var expected_amount = parseInt($("#payment-student").find('#expected_amount').val());
        var payable_amount =  parseInt($(this).val());
        var paid_amount = parseInt($("#payment-student").find("input[name='paid_amt']").val());
        var payableAmt = expected_amount - paid_amount;
        
        if(paid_amount == 0) {
            if( payable_amount > expected_amount) {
                $("#payment-student").find(".payable_amount-msg").text("amount should be less than expected amount");
                $("#payment-student").find("#payformsubmitbtn").prop("disabled", true);
            }
            else{
                 $("#payment-student").find("#payformsubmitbtn").prop("disabled", false);
             $("#payment-student").find(".payable_amount-msg").text("");
            }
        }
        else if( payable_amount > payableAmt) {
           
                $("#payment-student").find(".payable_amount-msg").text("You have already paid "+ paid_amount +", So Amount should be less than "+payableAmt+" amount");
                $("#payment-student").find("#payformsubmitbtn").prop("disabled", true);
        }
        else{
             $("#payment-student").find(".payable_amount-msg").text("");
            $("#payment-student").find("#payformsubmitbtn").prop("disabled", false);
        }
        
        if(payable_amount == "" ){
            $("#payment-student").find("#payformsubmitbtn").prop("disabled", false);
             $("#payment-student").find(".payable_amount-msg").text("");
        }
        
    });
    
    $("#payment-student").find('#expected_amount').on('input', function() {
        // Remove non-numeric characters from the input value
        var sanitized = $(this).val().replace(/[^0-9]/g, '');
        // Update the input value with the sanitized value
        $(this).val(sanitized);
        var expected_amount =  parseInt($(this).val());
        //alert(expected_amount);
        if(expected_amount == "" || isNaN(expected_amount) ){
            $("#payment-student").find("#payformsubmitbtn").prop("disabled", true);
             $("#payment-student").find(".expected_amount-msg").text("please enter amount");
        }
        else{
             $("#payment-student").find("#payformsubmitbtn").prop("disabled", false);
        }
    });
    
    $("#payment-student").on("submit", function(e){
        e.preventDefault();
        //alert("in");
        var stdId = $("#payment-student").find("input[name='std_id']").val();
       var expected_amount =  $("#payment-student").find("#expected_amount").val();
       var payable_amount =  $("#payment-student").find("#payable_amount").val();
       //alert(expected_amount);
       if(expected_amount != "" || payable_amount != "") {
            //alert("submit");
            var data = {
                action: 'ajax_pay_student',
                std_id: stdId,
                expected_amount: expected_amount,
                payable_amount: payable_amount
            }
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: data,
                beforeSend: function(msg){
        	        //jQuery("#preloader_two").css("display", "block");
        	    },
                success: function(response) {
                	//console.log(response);
                	jQuery('#payment-student')[0].reset();
                    setTimeout(function(){
                        
                        window.location.reload();
                    }, 800);
        
                },
                error: function(xhr){
                    console.log("Error: " + xhr.responseCode);
                }  
            });
       }
       else {
           //alert("out");
           return false
       }
    });
});


            
function ajax_student(data){
    
	jQuery.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: data,
        beforeSend: function(msg){
	        jQuery("#preloader_two").css("display", "block");
	    },
        success: function(response) {
        	console.log(response);
        	jQuery(".student_frm_sec").removeClass("showfrm");
        	jQuery("#preloader_two").css("display", "none");
        	jQuery("#student-basic-details").find(".notification_container").css("display", "block");
        	jQuery("#student-basic-details").find(".notification_container").html("<p>Student referred successfully</p>");
        	jQuery('#payment-student')[0].reset();

            setTimeout(function(){
                
                window.location.reload();
            }, 2000);

        },
        error: function(xhr){
            console.log("Error: " + xhr.responseCode);
        }  
    });
}
