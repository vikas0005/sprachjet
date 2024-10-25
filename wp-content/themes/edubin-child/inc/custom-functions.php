<?php

function custom_provider_registration_form_shortcode() {
    if ( is_admin() ) {  return; }
    if ( is_user_logged_in() ) {
        wp_redirect( home_url('/partner-register') );
    }
    else {
        ob_start();
        do_action( 'woocommerce_before_customer_login_form' );
        ?>
        
        	<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>
    
    		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
    
    			<?php do_action( 'woocommerce_register_form_start' ); ?>
    
    			    <input type="hidden" name="role" id="role" value="partner"/>
    			    <!-- Full Name Field -->
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="full_name"><?php _e( 'Full Name', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="full_name" id="full_name" placeholder="<?php _e( 'Enter your full name', 'woocommerce' ); ?>" required />
                    </p>
                
                    <!--Mobile Number Field -->
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="mob_number"><?php _e( 'Mobile Number', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="mob_number" id="mob_number" placeholder="<?php _e( 'Enter your mobile number', 'woocommerce' ); ?>" required />
                    </p>
    			
        			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text"  placeholder="<?php _e( 'Enter your email', 'woocommerce' ); ?>" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
        			</p>
    
    		
    				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password"  placeholder="<?php _e( 'Enter your password', 'woocommerce' ); ?>"/>
    					
    				</p>
    
    			    <!-- Confirm Password Field -->
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="confirm_password"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="confirm_password" id="confirm_password" placeholder="<?php _e( 'Confirm your password', 'woocommerce' ); ?>" required />
                    </p>
                    <span id="password-error" style="color: red;"></span>
                     <!--Select Branch Field -->
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="select_branch"><?php _e( 'Select Branch', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <select class="woocommerce-Input woocommerce-Input--text input-text" name="select_branch" id="select_branch" required>
                            <option value=""><?php _e( 'Select branch', 'woocommerce' ); ?></option>
                            <option value="Jaipur">Jaipur</option>
                              <option value="Bikaner">Bikaner</option>
                              <option value="Kekri">Kekri</option>
                              <option value="Shimoga">Shimoga</option>
                              <option value="Online Classes">Online Classes</option>
                        </select>
                       
                    </p>
    
    			<?php do_action( 'woocommerce_register_form' ); ?>
    
    			<p class="woocommerce-form-row form-row">
    				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
    				<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
    			</p>
    
    			<?php do_action( 'woocommerce_register_form_end' ); ?>
    
    		</form>
    		
        <?php  do_action( 'woocommerce_after_customer_login_form' );
        return ob_get_clean();
    }
}
add_shortcode( 'custom_provider_registration_form', 'custom_provider_registration_form_shortcode' );

add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10, 3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (strcmp($password, $confirm_password) !== 0) {
            $reg_errors->add('password_error', __('Passwords do not match.', 'woocommerce'));
        }
    }
    return $reg_errors;
}

function custom_customer_registration_form_shortcode() {
    if ( is_admin() ) {  return; }
    if ( is_user_logged_in() ) {
        wp_redirect( home_url('/my-account') );
    }
    else {
    ob_start();
    do_action( 'woocommerce_before_customer_login_form' );
    ?>
    
    	<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			
			    <!-- Full Name Field -->
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="full_name"><?php _e( 'Full Name', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="full_name" id="full_name" placeholder="<?php _e( 'Enter your full name', 'woocommerce' ); ?>" required />
                </p>
            
                <!--Mobile Number Field -->
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="mob_number"><?php _e( 'Mobile Number', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="mob_number" id="mob_number" placeholder="<?php _e( 'Enter your mobile number', 'woocommerce' ); ?>" required />
                </p>
			
    			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
    			</p>

		
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			    <!-- Confirm Password Field -->
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="confirm_password"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="confirm_password" id="confirm_password" placeholder="<?php _e( 'Confirm your password', 'woocommerce' ); ?>" required />
                </p>
            
			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
		
    <?php  do_action( 'woocommerce_after_customer_login_form' );
    return ob_get_clean();
    }
}
add_shortcode( 'custom_customer_registration_form', 'custom_customer_registration_form_shortcode' );

function custom_provider_login_form_shortcode() {
    
    if ( is_admin() ) {  return; }
    if ( is_user_logged_in() ) {
        wp_redirect( home_url('/my-account') );
    }
    else {
        
        ob_start();
        do_action( 'woocommerce_before_customer_login_form' ); ?>

    	<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
            <p>Not a Registered User ?<a href="<?php echo site_url('partner-register'); ?>"> Sign Up ! </a></p>
			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
        <?php
        do_action( 'woocommerce_after_customer_login_form' );
    }
    return ob_get_clean();
}
add_shortcode( 'custom_provider_login_form', 'custom_provider_login_form_shortcode' );

function custom_customer_login_form_shortcode() {
    
    if ( is_admin() ) {  return; }
    if ( is_user_logged_in() ) {
        wp_redirect( home_url('/my-account') );
        die();
    }
    else {
        
        ob_start();
        do_action( 'woocommerce_before_customer_login_form' ); ?>

    	<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
            <p>Not a Registered User ?<a href="<?php echo site_url('customer-register'); ?>"> Sign Up ! </a></p>
			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
        <?php
        do_action( 'woocommerce_after_customer_login_form' );
    }
    return ob_get_clean();
}
add_shortcode( 'custom_customer_login_form', 'custom_customer_login_form_shortcode' );

function wooc_save_extra_register_fields( $customer_id ) {
        $name = explode(" ", $_POST['full_name']);
        if ( isset( $_POST['mob_number'] ) ) {
            // Phone input filed which is used in WooCommerce
            update_user_meta( $customer_id, 'phone_number', sanitize_text_field( $_POST['mob_number'] ) );
            update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['mob_number'] ) );
        }
        
        if( isset( $_POST['email'] ) ) {
            update_user_meta( $customer_id, 'email', $_POST['email']  );
        }
        
        if (isset($_POST['role']) && !empty($_POST['role'])) {
            $role = sanitize_text_field($_POST['role']);
            
            // Get the current user object
            $user = new WP_User($customer_id);
            
            // Remove all existing roles from the user
            $user->set_role('');
            
            // Add the new role to the user
            $user->add_role($role);
        }
        if ( isset( $_POST['full_name'] ) ) {
             //First name field which is by default
             update_user_meta( $customer_id, 'first_name', sanitize_text_field( $name[0] ) );
             // First name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $name['0'] ) );
        }
        if ( isset( $_POST['last_name'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'last_name', sanitize_text_field( $name['1'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $name['1'] ) );
        }
        if(isset($_POST['select_branch'])) {
            update_user_meta($user_id, 'select_branch', $_POST['select_branch']);
        }
        
        // Check if select_branch meta field already exists
        $existing_branch = get_user_meta($customer_id, 'select_branch', true);
        if (empty($existing_branch)) {
            // If not, create it
            add_user_meta($customer_id, 'select_branch', $_POST['select_branch']);
        } else {
            // If it exists, update it
            update_user_meta($customer_id, 'select_branch', $_POST['select_branch']);
        }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

// Function to redirect users based on their role after login
add_filter( 'woocommerce_login_redirect', 'customer_login_redirect', 9999, 2 );
 
function customer_login_redirect( $redirect, $user ) {
    if ( is_admin() ) {  return; }
    if ( is_user_logged_in() ) {
        if ( wc_user_has_role( $user, 'partner' ) ) {
            $redirect = site_url('/partner-dashboard');
        }
        else {
            wp_redirect( home_url('/my-account') );
        }
    }
    
  
    return $redirect;
}

// Function to redirect users after registration
function custom_registration_redirect($redirect_to) {
    if ( is_admin() ) {  return; }
    
     // Return the default redirect URL if the user is not logged in
    if (!is_user_logged_in()) {
        return $redirect_to;
    }
    
    // Get the current user object
    $user = wp_get_current_user();
    
    if (in_array('partner', $user->roles)) {
        // Redirect partners to a different page after registration/login
        $redirect_url = home_url('/partner-dashboard');
    }
    
    return $redirect_url;
}
add_filter('woocommerce_registration_redirect', 'custom_registration_redirect');

function add_partner_students(){
    // Ensure we are dealing with an AJAX request
    if ( !isset($_POST['action']) || $_POST['action'] !== 'add_partner_students' ) {
        return;
    }
    if(isset($_POST['expected_amount'])) : unset($_POST['expected_amount']); endif;
    if(isset($_POST['payable_amount'])) : unset($_POST['payable_amount']); endif;
    if(isset($_POST['pay_submit'])) : unset($_POST['pay_submit']); endif;
    if(isset($_POST['std_id'])) : unset($_POST['std_id']); endif;
    
    
    // Retrieve form data
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $gender = $_POST['gender'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $mailing_state = $_POST['state'];
    $mailing_city = $_POST['city'];
    $mailing_pincode = $_POST['zipCode'];
    $remark = $_POST['remark'];
    $priority = $_POST['priority'];

    $post_id = wp_insert_post(array(
        'post_title' => $first_name . ' ' . $last_name,
        'post_type' => 'student',
        'post_status' => 'publish',
        'meta_input' => array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $gender,
            'phone_no' => $phone_no,
            'email' => $email,
            'mailing_state' => $mailing_state,
            'mailing_city' => $mailing_city,
            'mailing_pincode' => $mailing_pincode,
            'remark' => $remark,
            'priority' => $priority,
            'application_status' => 'Pending'
        )
    ));
    if($post_id) {
        add_post_meta($post_id, 'remark', $remark);
         // Get the author's information
        $author = get_userdata(get_post_field('post_author', $post_id));
        $author_name = $author->display_name;
        
        // Compose the email subject and body
        $subject = 'New Student Post Created: ' . $first_name . ' ' . $last_name;
        $message = 'A new student refer has been received on your website.' . "\n\n";
        $message .= 'Student name: ' . $first_name . ' ' . $last_name . "\n";
        $message .= 'Gender: ' . $gender . "\n";
        $message .= 'Phone no.: ' . $phone_no. "\n";
        $message .= 'Email: ' . $email. "\n";
        $message .= 'Address: ' . $mailing_city . ', ' . $mailing_state.', '. $mailing_pincode."\n";
        $message .= 'Refer For: ' . $priority. "\n";
        $message .= 'Refer By: ' . $author_name . "\n";
        $message .= 'Application Status: ' . 'Pending' . "\n";
        
        // Get the admin email address
        $admin_email = 'info@sprachjet.com';
        
        // Send the email
        wp_mail($admin_email, $subject, $message);
    }

    exit();
    // Success response
    //wp_send_json_success( 'Post created successfully', $post_id );
}
add_action('wp_ajax_add_partner_students', 'add_partner_students');
add_action('wp_ajax_nopriv_add_partner_students', 'add_partner_students');

function edit_partner_profile(){
    // Ensure we are dealing with an AJAX request
    if ( !isset($_POST['action']) || $_POST['action'] !== 'edit_partner_profile' ) {
        return;
    }

    $user = wp_get_current_user();
    $user_id = $user->ID;

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $pemail = $_POST['pemail'];
    $pmobile = $_POST['pmobile'];
    $display_name = $_POST['first_name'].' '.$_POST['last_name'];
    
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = esc_attr( $_POST['city']);
    $zipcode = $_POST['zipcode'];
    $landmark = $_POST['landmark'];
    $account_number = $_POST['account_number'];
    $bankname = $_POST['bankname'];
    $branchname = $_POST['branchname'];
    $ifsc_code = $_POST['ifsc_code'];
    $pancard_no = $_POST['pancard_no'];
    $adharcard_no = $_POST['adharcard_no'];

    update_user_meta($user_id, 'user_email', $pemail);
    wp_update_user( $user_id, 'display_name', $display_name );
    
    if ( isset( $_POST['pmobile'] ) ) {
        // Phone input filed which is used in WooCommerce
        update_user_meta( $user_id, 'phone_number', sanitize_text_field( $_POST['pmobile'] ) );
        update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['pmobile'] ) );
    }
   
    if ( isset( $_POST['first_name'] ) ) {
         //First name field which is by default
         update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
         // First name field which is used in WooCommerce
         update_user_meta( $user_id, 'billing_first_name', sanitize_text_field( $_POST['first_name'] ) );
    }
    if ( isset( $_POST['last_name'] ) ) {
         // Last name field which is by default
         update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
         // Last name field which is used in WooCommerce
         update_user_meta( $user_id, 'billing_last_name', sanitize_text_field( $_POST['last_name'] ) );
    }
    
    update_user_meta($user_id, 'billing_address_1', $address);
    update_user_meta($user_id, 'billing_state', $state);
    update_user_meta($user_id, 'billing_city', $city);
    update_user_meta($user_id, 'billing_postcode', $zipcode);
 
    
    $existing_landmark = get_user_meta($user_id, 'landmark', true);
    $existing_account_number = get_user_meta($user_id, 'account_number', true);
    $existing_bankname = get_user_meta($user_id, 'bankname', true);
    $existing_branchname = get_user_meta($user_id, 'branchname', true);
    $existing_ifsc_code = get_user_meta($user_id, 'ifsc_code', true);
    $existing_pancard_no = get_user_meta($user_id, 'pancard_no', true);
    $existing_adharcard_no = get_user_meta($user_id, 'adharcard_no', true);

    ( empty($account_number) ? add_user_meta($user_id, 'landmark', $landmark) : update_user_meta($user_id, 'landmark', $landmark) ); 
    ( empty($existing_account_number) ? add_user_meta($user_id, 'account_number', $account_number) : update_user_meta($user_id, 'account_number', $account_number) ); 
    ( empty($existing_bankname) ? add_user_meta($user_id, 'bankname', $bankname) : update_user_meta($user_id, 'bankname', $bankname) ); 
    ( empty($existing_branchname) ? add_user_meta($user_id, 'branchname', $branchname) : update_user_meta($user_id, 'branchname', $branchname) ); 
    ( empty($existing_ifsc_code) ? add_user_meta($user_id, 'ifsc_code', $ifsc_code) : update_user_meta($user_id, 'ifsc_code', $ifsc_code) );
    ( empty($existing_pancard_no) ? add_user_meta($user_id, 'pancard_no', $pancard_no) : update_user_meta($user_id, 'pancard_no', $pancard_no) );
    ( empty($existing_adharcard_no) ? add_user_meta($user_id, 'adharcard_no', $adharcard_no) : update_user_meta($user_id, 'adharcard_no', $adharcard_no) );
    
    //print_r($_FILES);
   // Process uploaded files
   
    if ( $_FILES['pancardfie'] ) {
        
        $file = $_FILES['pancardfie'];
        $upload_url = upload_images($file['name'], $file['tmp_name']);
        if($upload_url) :
            update_user_meta($user_id, 'pencard_img_url', $upload_url);
        endif;
    }
    if ( $_FILES['adharcardfile'] ) {
        
        $file = $_FILES['adharcardfile'];
        $upload_url = upload_images($file['name'], $file['tmp_name']);
        if($upload_url) :
            update_user_meta($user_id, 'asharcard_img_url', $upload_url);
        endif;
    }
     if ( $_FILES['profilepic'] ) {
        
        $file = $_FILES['profilepic'];
        $upload_url = upload_images($file['name'], $file['tmp_name']);
        if($upload_url) :
            // update_user_meta($user_id, 'profile_image', $attach_id );
            update_user_meta($user_id, 'profile_image_url', $upload_url);
        endif;
    }
    
    ob_start(); ?>
    
    <div class="teacher-profile-img">
        <?php $pro_img = ( get_user_meta($user_id, 'profile_image_url', true) ? get_user_meta($user_id, 'profile_image_url', true) : "https://sprachjet.com/wp-content/uploads/2024/05/img_avatar.png"); ?>
        <img src="<?php echo $pro_img; ?>" />
        <div class="profile-msg" style="color: red;"></div>
        
        <div class="techer-profile-edit-area">
            <button type="button" class="edit_partner_profile btn btn-primary" ><i class="far fa-edit"></i></button>
        </div>
    </div>
    <div class="teacher-name">
        <?php $first_name = get_user_meta($user_id, 'first_name', true);
        $last_name = get_user_meta($user_id, 'last_name', true); ?>
        <h4 id="partner_name"><?php echo $first_name.' '.$last_name; ?></h4>
        <p id="partner_phone">Mob. : <?php echo get_user_meta($user_id, 'phone_number', true); ?></p>
        <p id="partner_email">Email : <?php echo get_user_meta($user_id, 'user_email', true); ?></p>
    </div>
    <?php 
    $output = ob_get_clean();
    echo $output;
exit();
    // Success response
    //wp_send_json_success( 'Post created successfully', $post_id );
}
add_action('wp_ajax_edit_partner_profile', 'edit_partner_profile');
add_action('wp_ajax_nopriv_edit_partner_profile', 'edit_partner_profile');


function upload_images($fileName, $tmpName){
    $uploaddir = wp_upload_dir();
    $uploadfile = $uploaddir['path'] . '/' . basename($fileName);

    // Move uploaded file to the upload directory
    if (move_uploaded_file($tmpName, $uploadfile)) {
        $filename = basename($uploadfile);
        $wp_filetype = wp_check_filetype($filename, null);

        // Check file type
        if (!$wp_filetype['ext']) {
            wp_die("Unsupported file type.");
        }

        // Prepare attachment data
        $attachment = array(
            'guid'           => $uploaddir['url'] . '/' . $filename,
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert attachment into the media library
        $attach_id = wp_insert_attachment($attachment, $uploadfile);

        if (is_wp_error($attach_id)) {
            wp_die("Error inserting attachment: " . $attach_id->get_error_message());
        }

        // Generate metadata for the attachment
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $uploadfile);
        wp_update_attachment_metadata($attach_id, $attach_data);

        // Get attachment URL
        $attachment_url = wp_get_attachment_url($attach_id);
        
        
    } else {
        wp_die("Failed to move uploaded file.");
    }
    return $attachment_url;
}

function update_student_status(){
    if( $_POST['stdid'] && $_POST['application_status'] ) {
        update_post_meta($_POST['stdid'], 'application_status', $_POST['application_status']);
    }
    exit();
}
add_action('wp_ajax_update_student_status', 'update_student_status');
add_action('wp_ajax_nopriv_update_student_status', 'update_student_status');

function all_student_details(){
    if( $_POST['stdid'] ) {
        $students_query = new WP_Query(array(
            'post_type' => 'student', 
            'posts_per_page' => -1,
            'post__in' => array( $_POST['stdid'] )
        ));
        ob_start();
        if($students_query->have_posts()){
            while($students_query->have_posts()) : $students_query->the_post();?>
            <h3 class="text-center">Student Name:- <strong class="text-red"><?php the_title(); ?></strong></h3>
            <div class="student-details-view">
                <p><strong>Gender:-</strong> <span><?php echo get_field('gender'); ?></span></p>
                <p><strong>email:-</strong> <span><?php echo get_field('email'); ?></span></p>
                <p><strong>Phone no.:-</strong> <span><?php echo get_field('phone_no'); ?></span></p>
                <p><strong>Refer For:-</strong> <span><?php echo get_field('priority'); ?></span></p>
                <p><strong>Address:-</strong> <span><?php echo get_field('mailing_state').', '.  get_field('mailing_city').', '.  get_field('mailing_pincode'); ?></span></p>
                <p><strong>Other Remark:-</strong> <span><?php echo get_field('remark'); ?></span></p>
                <p><strong>Application Status:-</strong> <span><?php echo get_field('application_status'); ?></span></p>
            </div>
            <?php endwhile; wp_reset_postdata();
        }
        $output = ob_get_clean();
    }
    echo $output;
    die();
}
add_action('wp_ajax_all_student_details', 'all_student_details');
add_action('wp_ajax_nopriv_all_student_details', 'all_student_details');

function login_redirect_based_on_role( $redirect_to, $request, $user ) {
    // Check if the user is logged in and has a role
    if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        // Get the roles for the user
        $roles = $user->roles;

        // Check if the user has a specific role
        if ( in_array( 'administrator', $roles ) ) {
            // Redirect administrators to a specific page
            return home_url( 'wp-admin' );
        } elseif ( in_array( 'partner', $roles ) ) {
            // Redirect editors to another page
            return home_url( 'partner-dashboard' );
        } else {
            // Redirect authors to yet another page
            return home_url( 'my-account' );
        }
        // Add more role checks and redirections as needed
    }

    // Default redirect if no role matches
    return $redirect_to;
}
add_filter( 'login_redirect', 'login_redirect_based_on_role', 10, 3 );

function ajax_pay_student(){
    if( $_POST['std_id'] ) {
        $std_id = $_POST['std_id'];
        $expected_amount = $_POST['expected_amount'];
        $payable_amount = $_POST['payable_amount'];
        
        $expected_amt = get_post_meta($std_id, 'expected_amount', true);
        $payable_amt = get_post_meta($std_id, 'payable_amount', true);
        
        $new_value = $payable_amount;
    
        // If no array exists, create a new one
        if (!$payable_amt) {
            $payable_amt = array();
        }
    
        // Add the new value to the array
        $payable_amt[] = $new_value;
        
        if($expected_amt || $payable_amt) {
            update_post_meta($std_id, 'expected_amount', $expected_amount);
            if(!empty($payable_amt) && $new_value != '') {
                update_post_meta($std_id, 'payable_amount', $payable_amt);
            }
    
        }
        else {
            add_post_meta($std_id, 'expected_amount', $expected_amount);
            if(!empty($payable_amt)) {
                add_post_meta($std_id, 'payable_amount', $payable_amt);
            }
    
        }
    }
    die();
}
add_action('wp_ajax_ajax_pay_student', 'ajax_pay_student');
add_action('wp_ajax_nopriv_ajax_pay_student', 'ajax_pay_student');

