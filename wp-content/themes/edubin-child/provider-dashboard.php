<?php
/* Template Name: Partner Dashboard
*/
get_header();
?>
<section class="">
    <div class="container">
        <form method="POST" action="" class="fromt-desk-form-student-info needs-validation" role="form" id="create-student" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="VLbh8GuknBf5Gn2dWneM6tXFQ4DaunyScfScSfjp">

        <div class="row">
          <div class="col-md-12 pt-0">
            <div class="moec-card-styl">
              <div class="moec-lead-tab-head mb-2">
                <h4>Student Basic Details</h4>
              </div>
              <div class="row">
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <input type="text" class="form-control" placeholder="First Name" value="" name="first_name" id="first_name"  >
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <div class="first_name-msg" style="color: red;"></div>
                  </div>
                </div>

                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <input type="text" class="form-control" placeholder="Last Name" value="" name="last_name" id="last_name" >
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <div class="last_name-msg" style="color: red;"></div>
                  </div>
                </div>
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <select class="form-select" name="gender" id="gender" >
                        <option value="">Choose...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <div class="gender-msg" style="color: red;"></div>
                  </div>
                </div>
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="front-desk-form-input-group input-group">
                    <select class="input-grp-select" name="country_code" id="country_code">
                                                     <option value="93">93</option>
                                                 <option value="355">355</option>
                                                 <option value="213">213</option>
                                                 <option value="1684">1684</option>
                                                 <option value="376">376</option>
                                                 <option value="244">244</option>
                                                 <option value="1264">1264</option>
                                                 <option value="0">0</option>
                                                 <option value="1268">1268</option>
                                                 <option value="54">54</option>
                                                 <option value="374">374</option>
                                                 <option value="297">297</option>
                                                 <option value="61">61</option>
                                                 <option value="43">43</option>
                                                 <option value="994">994</option>
                                                 <option value="1242">1242</option>
                                                
                                              </select>
                    <div class="create-lead-floating form-floating">
                      <input type="text" class="form-control" name="phone_no" placeholder="+91-123456789">
                      <label class="form-label">Alt. Mobile No.</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <input type="email" class="form-control" placeholder="Primary Email" name="email" id="email" value="" >
                    <label class="form-label">Primary Email <span class="text-danger">*</span></label>
                    <div class="email-msg" style="color: red;"></div>
                  </div>
                </div>

                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <select onchange="print_city('state', this.selectedIndex);" id="sts" name ="sts" class="form-control" required></select>
                    <script language="javascript">print_state("sts");</script>

                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <div class="StateList-msg" style="color: red;"></div>
                  </div>
                </div>
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <select id ="state" class="form-control" name="city" required></select>

                    <label class="form-label">City <span class="text-danger">*</span></label>
                    <div class="CityList-msg" style="color: red;"></div>
                  </div>
                </div>
                <div class="col-md-4 col-xl-4 col-xxl-4">
                  <div class="create-lead-floating form-floating">
                    <input type="text" class="form-control" placeholder="Zip Code" name="mailing_pincode" id="mailing_pincode">
                    <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                    <div class="mailing_pincode-msg" style="color: red;"></div>
                  </div>
                </div>

                <div class="col-md-12 col-xl-12 col-xxl-12">
                  <div class="create-lead-floating form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" name="remark"></textarea>
                    <label for="floatingTextarea2">Other/Remarks</label>
                  </div>
                </div>
                
                <div class="col-md-12 ">
                    <div class="input-line-label">
                        <label>Priority </label>
                        <select class="form-select" name="priority" aria-label="Default select example" >
                            <option value="">---Select---</option>
                            <option value="3">Hot</option>
                            <option value="2">Warm</option>
                            <option value="1">Cold</option>
                        </select>
                        <div class="mailing_priority-msg" style="color: red;"></div>
                    </div>
                </div>
                
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="mt-3 mb-3">
              <div class="moec-lead-tab-head">
                <button class="btn btn-moec btn-secondary" onclick="resetForm()" type="reset"><i class="fa-solid fa-arrows-rotate"></i> &nbsp; Reset</button>
                <button class="btn btn-moec btn-primary" type="submit" id="formsubmitbtn"><i class="fa-solid fa-check"></i>
                  &nbsp; Submit</button>
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>
</section>

<?php
// Get current user ID
$current_user_id = get_current_user_id();
// Custom query to retrieve students with partner information
$students_query = new WP_Query(array(
    'post_type' => 'student', // Assuming 'student' is the custom post type name
    'posts_per_page' => -1, // Retrieve all students
    'author' => $current_user_id 
));

if ($students_query->have_posts()) :
?>
<table>
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Application Status</th>
            <th>Gender</th>
            <th>Email</th>
            <th>State</th>
            <th>City</th>
            <th>Zip Code</th>
            <th>Partner Name</th>
            <!-- Add more columns as needed for partner information -->
        </tr>
    </thead>
    <tbody>
        <?php while ($students_query->have_posts()) : $students_query->the_post(); ?>
            <tr>
                <td><?php the_ID(); ?></td>
                <td><?php the_title(); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'application_status', true); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'gender', true); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'email', true); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'mailing_state', true); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'mailing_city', true); ?></td>
                <td><?php echo get_post_meta(get_the_ID(), 'mailing_pincode', true); ?></td>
                <td><?php echo get_the_author_meta('display_name'); ?></td>
                <!-- Add more cells for additional partner information if needed -->
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php
// Restore original post data
wp_reset_postdata();
endif;
?>
          
<?php
//print_r($_POST);
if(isset($_POST) && !empty($_POST) ) {
    
    // Retrieve form data
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $gender = sanitize_text_field($_POST['gender']);
    $country_code = sanitize_text_field($_POST['country_code']);
    $phone_no = sanitize_text_field($_POST['phone_no']);
    $email = sanitize_email($_POST['email']);
    $mailing_state = sanitize_text_field($_POST['sts']);
    $mailing_city = sanitize_text_field($_POST['city']);
    $mailing_pincode = sanitize_text_field($_POST['mailing_pincode']);
    $remark = sanitize_text_field($_POST['remark']);
    $priority = sanitize_text_field($_POST['priority']);

    // Create post
    $post_id = wp_insert_post(array(
        'post_title' => $first_name . ' ' . $last_name,
        'post_type' => 'student',
        'post_status' => 'publish',
        'meta_input' => array(
            'gender' => $gender,
            'country_code' => $country_code,
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

    // if (!is_wp_error($post_id)) {
    //     // Post created successfully
    //     return new WP_REST_Response(array('success' => true, 'post_id' => $post_id), 200);
    // } else {
    //     // Error occurred
    //     return new WP_Error('error', 'Error creating post', array('status' => 500));
    // }
}

get_footer();