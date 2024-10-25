<?php
/* Template Name: Partner Dashboard Html
*/
get_header();
if (is_user_logged_in()) {
    $user = wp_get_current_user();
    // Check if user is admin or customer
    if (in_array('administrator', $user->roles) || in_array('customer', $user->roles)) {
        // Redirect to home page
        wp_redirect(home_url());
        exit;
    }
}
else{
    wp_redirect(home_url());
        exit;
}

//update student
if( isset($_POST['editsubmitbtn']) ) {
    $std_id = $_POST['std_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'.$std_id];
    $mailing_state = $_POST['sts'.$std_id];
    $mailing_city = $_POST['city'];
    $mailing_pincode = $_POST['mailing_pincode'];
    $remark = $_POST['remark'];
    $priority = $_POST['priority'];
    $application_status = $_POST['application_status'];
    
    $my_post = array(
      'ID'           => $std_id,
      'post_title'   => $first_name. ' ' .$last_name
    );

    wp_update_post( $my_post );
    
    update_post_meta($std_id, 'first_name', $first_name);
    update_post_meta($std_id, 'email', $email);
    update_post_meta($std_id, 'gender', $gender);
    update_post_meta($std_id, 'last_name', $last_name);
    update_post_meta($std_id, 'phone_no', $phone_no);
    update_post_meta($std_id, 'mailing_state', $mailing_state);
    update_post_meta($std_id, 'mailing_city', $mailing_city);
    update_post_meta($std_id, '$mailing_pincode', $$mailing_pincode);
    update_post_meta($std_id, 'remark', $remark);
    update_post_meta($std_id, 'priority', $priority);
    update_post_meta($std_id, 'application_status', $application_status);
}

// Get current user ID
$current_user = wp_get_current_user();
//print_r($current_user);

$current_user_id = get_current_user_id();
$students_query = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id 
));
$allStudents = $students_query->found_posts;

$students_leads = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id,
    'meta_query' => array(
        array(
            'key' => 'application_status',
            'value' => array( 'In Progress', 'In Discussion', 'Registration Done', 'Lead Converted', 'Fee Deposited'),
            'operator'   => 'IN'
        ),
    )
));
$allLeadStudents = $students_leads->found_posts;

$students_done = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id,
    'meta_query' => array(
        array(
            'key' => 'application_status',
            'value' => 'Registration Done',
            'campare'   => 'LIKE'
        ),
    )
));
$allApplicationDone = $students_done->found_posts;

$students_drop = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id,
    'meta_query' => array(
        array(
            'key' => 'application_status',
            'value' => 'Drop',
            'campare'   => 'LIKE'
        ),
    )
));
$allApplicationDrop = $students_drop->found_posts;

$transationList  = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id,
    'meta_query' => array(
        array(
            'key' => 'payable_amount',
            'campare'   => 'EXISTS'
        ),
    )
));
$countPaidAmt = "0";
while ($transationList->have_posts()) : $transationList->the_post();
    $paid_amt = get_post_meta(get_the_ID(), 'payable_amount', true);
    
    if(!empty($paid_amt)) {
        $countPaidAmt += array_sum($paid_amt);
    }
    
endwhile; wp_reset_postdata();

$expectedAmt  = new WP_Query(array(
    'post_type' => 'student', 
    'posts_per_page' => -1,
    'author' => $current_user_id,
    'meta_query' => array(
        array(
            'key' => 'expected_amount',
            'campare'   => 'EXISTS'
        ),
    )
));
$countExpectedAmt = 0;
while ($expectedAmt->have_posts()) : $expectedAmt->the_post();
    $exp_amount = get_post_meta(get_the_ID(), 'expected_amount', true);
    if(!empty($exp_amount)) {
        $countExpectedAmt += $exp_amount;
    }
endwhile; wp_reset_postdata();

$totalPayableAmount = $countExpectedAmt;
if($countExpectedAmt != 0 && $countPaidAmt != 0){
$totalPayableAmount = $countExpectedAmt - $countPaidAmt;
}

?>


<!-- main-dashbord-wrapper-start-->
<div class="main-dasbord-wrapper">
    <div class="container">
        <div class="notification_container" style="display: none;"></div>
    </div>
    
    <div class="container-fluid">
        <div class="ref-btn-comman">
            <button type="button" class="btn btn-primary refer_std" data-bs-toggle="modal" data-bs-target="#student-basic-details"><i class="fas fa-user-plus"></i><span>Refer Students</span></button>
            <button type="button" class="btn btn-primary quick_update_status" data-bs-toggle="modal" data-bs-target="#confirmationModal" style="display: none;">
            </button>
            <button type="button" class="btn btn-primary std_view_more" data-bs-toggle="modal" data-bs-target="#viewmoreModal" style="display: none;">
            </button>
            <button type="button" class="btn btn-primary pay_actionbtn" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="#student-payment-details" style="display: none;">Payment</button>

        </div>
        <div class="main-form-inner-box">
        
        <div class="left-dabord-box">
            <div class="top-dashbord-inner">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <span><i class="fas fa-border-all"></i></span> Dashboard
                        </button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <span><i class="fas fa-users-cog"></i></span> Lead
                        </button>
                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                            <span><i class="fas fa-user-plus"></i> </span> Student
                        </button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                            <span> <i class="fas fa-wallet"></i></span> Wallet
                        </button>
                        <button class="nav-link" id="v-pills-wallet-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wallet" type="button" role="tab" aria-controls="v-pills-wallet" aria-selected="false">
                            <span><i class="far fa-user"></i></span> Profile
                        </button>

                          <button class="nav-link" data-bs-toggle="pill"  type="button" role="tab">
                           <a href="<?php echo esc_url(wp_logout_url( home_url('/') )); ?>"> <span><i class="fas fa-sign-out-alt"></i></span> Logout</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-dashbord-inner">

            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="dashboard-box-screen">
                    

                        <div class="card-main-mockup">
                            <div class="sprachjet-count-card">
                                <div class="product-name-details">
                                    <div class="card-content">
                                        <img src="https://sprachjet.com/wp-content/uploads/2024/04/Studentsreferred-svg.png" class="bg-primary-subtle" />
                                        <div>
                                            <h4 class="number-counter"><?php echo $allStudents; ?></h4>
                                            <div class="card-name-listed">Students Referred</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sprachjet-count-card">
                                <div class="product-name-details">
                                    <div class="card-content">
                                        <img src="https://sprachjet.com/wp-content/uploads/2024/04/DepositsDone-svg.png" class="bg-info-subtle" />
                                        <div>
                                            <h4 class="number-counter"><?php echo $allLeadStudents; ?></h4>
                                            <div class="card-name-listed">Leads</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sprachjet-count-card">
                                <div class="product-name-details">
                                    <div class="card-content">
                                        <img src="https://sprachjet.com/wp-content/uploads/2024/04/Applications-svg.png" class="bg-danger-subtle" />
                                        <div>
                                            <h4 class="number-counter"><?php echo $allApplicationDone; ?></h4>
                                            <div class="card-name-listed">Applications Done</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sprachjet-count-card">
                                <div class="product-name-details">
                                    <div class="card-content">
                                        <img src="https://sprachjet.com/wp-content/uploads/2024/04/OfferReceived-1.png" class="bg-warning-subtle" />
                                        <div>
                                            <h4 class="number-counter"><?php echo $allApplicationDrop; ?></h4>
                                            <div class="card-name-listed">Student Drop</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($students_query->have_posts()) : ?>
                        <div class="card-comman-box">
                            <div class="table-responsive">
                                <table class="table comman-table" id="all_list_std">
                                    <thead>
                                        <tr>
                                            <th>Lead Id</th>
                                            <th>Student Name</th>
                                            <th>Application Status</th>
                                            <th>Status Note</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Create date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($students_query->have_posts()) : $students_query->the_post(); ?>
                                        <tr>
                                            <td class="std-id"><?php the_ID(); ?></td>
                                            <td><?php echo get_post_meta(get_the_ID(), 'first_name', true).' '.get_post_meta(get_the_ID(), 'last_name', true); ?> </td>
                                            <td><?php $applicationStatus =  get_post_meta(get_the_ID(), 'application_status', true); ?> 
                                            <select name="change_status" class="change_status">
                                                <option value="Pending" <?php if($applicationStatus == "Pending") { echo "selected"; } ?>>Pending</option>
                                                <option value="In Progress" <?php if($applicationStatus == "In Progress") { echo "selected"; } ?>>In Progress</option>
                                                <option value="In Discussion" <?php if($applicationStatus == "In Discussion") { echo "selected"; } ?>>In Discussion</option>
                                                <option value="Registration Done" <?php if($applicationStatus == "Registration Done") { echo "selected"; } ?>>Registration Done</option>
                                                <option value="Lead Converted" <?php if($applicationStatus == "Lead Converted") { echo "selected"; } ?>>Lead Converted</option>
                                                <option value="Fee Deposited" <?php if($applicationStatus == "Fee Deposited") { echo "selected"; } ?>>Fee Deposited</option>
                                                <option value="Drop" <?php if($applicationStatus == "Drop") { echo "selected"; } ?>>Drop</option>
                                            </select></td>
                                            <td><?php echo get_post_meta(get_the_ID(), 'remark', true); ?></td>
                                            <td><a href="mailto:<?php echo get_post_meta(get_the_ID(), 'email', true); ?>"><?php echo get_post_meta(get_the_ID(), 'email', true); ?></a></td>
                                            <td><a href="tel:<?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?>"><?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?></a></td>
                                            <td><?php echo get_the_date(); ?></td>
                                            <td> <div class="action_div">
                                                <button type="button" class="btn btn-primary edit_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="#edit-student-details<?php the_ID(); ?>">Edit</button>
                                                <button type="button" class="btn btn-primary view_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="">View</button>
                                                <?php $paid_amount = ( get_post_meta(get_the_ID(), 'payable_amount', true) ? get_post_meta(get_the_ID(), 'payable_amount', true) : '0' ); ?>
                                                <button type="button" class="btn btn-primary pay_action" data-id="<?php the_ID(); ?>" expected-amt="<?php echo get_post_meta(get_the_ID(), 'expected_amount', true); ?>" paid-amt="<?php if($paid_amount != "0") : echo array_sum($paid_amount); else : echo $paid_amount; endif; ?>" data-bs-toggle="modal" data-bs-target="">Payment</button>
                                            </div>
                                            </td>
                                        </tr>
                                 
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                        

                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="dashboard-box-screen">
                        <div class="card-comman-box">
                            <h2 class="title-comman">Lead List Filter</h2>
                        </div>
                        
                        <?php if ($students_leads->have_posts()) : ?>
                        <div class="card-comman-box">
                            <div class="table-responsive">
                                <table class="table comman-table" id="lead_student_list">
                                    <thead>
                                        <tr>
                                            <th>Lead ID</th>
                                            <th>Name</th>
                                            <th>Application Status</th>
                                            <!--<th>Gender</th>-->
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <!--<th>Address</th>-->
                                            <th>Create date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($students_leads->have_posts()) : $students_leads->the_post(); ?>
                                        <tr>
                                            <td class="std-id"><?php the_ID(); ?></td>
                                            <td><?php echo get_post_meta(get_the_ID(), 'first_name', true).' '.get_field(get_the_ID(), 'last_name', true); ?></td>
                                            <td><?php $applicationStatus =  get_post_meta(get_the_ID(), 'application_status', true); ?> 
                                            <select name="change_status" class="change_status">
                                                <option value="Pending" <?php if($applicationStatus == "Pending") { echo "selected"; } ?>>Pending</option>
                                                <option value="In Progress" <?php if($applicationStatus == "In Progress") { echo "selected"; } ?>>In Progress</option>
                                                <option value="In Discussion" <?php if($applicationStatus == "In Discussion") { echo "selected"; } ?>>In Discussion</option>
                                                <option value="Registration Done" <?php if($applicationStatus == "Registration Done") { echo "selected"; } ?>>Registration Done</option>
                                                <option value="Lead Converted" <?php if($applicationStatus == "Lead Converted") { echo "selected"; } ?>>Lead Converted</option>
                                                <option value="Fee Deposited" <?php if($applicationStatus == "Fee Deposited") { echo "selected"; } ?>>Fee Deposited</option>
                                                <option value="Drop" <?php if($applicationStatus == "Drop") { echo "selected"; } ?>>Drop</option>
                                            </select></td>
                                            <!--<td><?php echo get_post_meta(get_the_ID(), 'gender', true); ?></td>-->
                                            <td><a href="mailto:<?php echo get_post_meta(get_the_ID(), 'email', true); ?>"><?php echo get_post_meta(get_the_ID(), 'email', true); ?></a></td>
                                            <td><a href="tel:<?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?>"><?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?></a></td>
                                            <!--<td><?php echo get_post_meta(get_the_ID(), 'mailing_state', true).','.get_post_meta(get_the_ID(), 'mailing_city', true); ?></td>-->
                                            <td><?php echo get_the_date(); ?></td>
                                            <td> <div class="action_div">
                                                <button type="button" class="btn btn-primary edit_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="#edit-student-details<?php the_ID(); ?>">Edit</button>
                                                <button type="button" class="btn btn-primary view_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="">View</button>
                                                <?php $paid_amount = ( get_post_meta(get_the_ID(), 'payable_amount', true) ? get_post_meta(get_the_ID(), 'payable_amount', true) : '0' ); ?>
                                                <button type="button" class="btn btn-primary pay_action" data-id="<?php the_ID(); ?>" expected-amt="<?php echo get_post_meta(get_the_ID(), 'expected_amount', true); ?>" paid-amt="<?php if($paid_amount != "0") : echo array_sum($paid_amount); else : echo $paid_amount; endif; ?>"  data-bs-toggle="modal" data-bs-target="">Payment</button>
                                            </div></td>
                                            
                                        </tr>
                                        
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="dashboard-box-screen">
                        <div class="card-comman-box">
                            <h2 class="title-comman">Student List</h2>
                        </div>
                        
                        <?php if ($students_query->have_posts()) : ?>
                        <div class="card-comman-box">
                            <div class="table-responsive">
                                <table class="table comman-table" id="all_student_list">
                                    <thead>
                                        <tr>
                                            <th>Lead Id</th>
                                            <th>Student Name</th>
                                            <th>Application Status</th>
                                            <!--<th>Gender</th>-->
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <!--<th>Address</th>-->
                                            <th>Create date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($students_query->have_posts()) : $students_query->the_post(); ?>
                                        <tr>
                                            <td class="std-id"><?php the_ID(); ?></td>
                                            <td><?php echo get_post_meta(get_the_ID(), 'first_name', true).' '.get_post_meta(get_the_ID(), 'last_name', true); ?> </td>
                                            <td><?php $applicationStatus =  get_post_meta(get_the_ID(), 'application_status', true); ?> 
                                            <select name="change_status" class="change_status">
                                                <option value="Pending" <?php if($applicationStatus == "Pending") { echo "selected"; } ?>>Pending</option>
                                                <option value="In Progress" <?php if($applicationStatus == "In Progress") { echo "selected"; } ?>>In Progress</option>
                                                <option value="In Discussion" <?php if($applicationStatus == "In Discussion") { echo "selected"; } ?>>In Discussion</option>
                                                <option value="Registration Done" <?php if($applicationStatus == "Registration Done") { echo "selected"; } ?>>Registration Done</option>
                                                <option value="Lead Converted" <?php if($applicationStatus == "Lead Converted") { echo "selected"; } ?>>Lead Converted</option>
                                                <option value="Fee Deposited" <?php if($applicationStatus == "Fee Deposited") { echo "selected"; } ?>>Fee Deposited</option>
                                                <option value="Drop" <?php if($applicationStatus == "Drop") { echo "selected"; } ?>>Drop</option>
                                            </select></td>
                                            <!--<td><?php echo get_post_meta(get_the_ID(), 'gender', true); ?></td>-->
                                            <td><a href="mailto:<?php echo get_post_meta(get_the_ID(), 'email', true); ?>"><?php echo get_post_meta(get_the_ID(), 'email', true); ?></a></td>
                                            <td><a href="tel:<?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?>"><?php echo get_post_meta(get_the_ID(), 'phone_no', true); ?></a></td>
                                            <!--<td><?php echo get_post_meta(get_the_ID(), 'mailing_state', true).','.get_post_meta(get_the_ID(), 'mailing_city', true); ?></td>-->
                                            <td><?php echo get_the_date(); ?></td>
                                            <td><div class="action_div">
                                                <button type="button" class="btn btn-primary edit_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="#edit-student-details<?php the_ID(); ?>">Edit</button>
                                                <button type="button" class="btn btn-primary view_action" data-id="<?php the_ID(); ?>" data-bs-toggle="modal" data-bs-target="">View</button>
                                                <?php $paid_amount = ( get_post_meta(get_the_ID(), 'payable_amount', true) ? get_post_meta(get_the_ID(), 'payable_amount', true) : '0' ); ?>
                                                <button type="button" class="btn btn-primary pay_action" data-id="<?php the_ID(); ?>" expected-amt="<?php echo get_post_meta(get_the_ID(), 'expected_amount', true); ?>" paid-amt="<?php if($paid_amount != "0") : echo array_sum($paid_amount); else : echo $paid_amount; endif; ?>"  data-bs-toggle="modal" data-bs-target="">Payment</button>
                                            </div></td>
                                        </tr>
                                       
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="dashboard-box-screen">
                        <div class="sprachjet-count-wrapper">
                            <div class="sprachjet-count-card-box bg-primary-subtle">
                                <div class="product-name-details">
                                    <div class="card-content wallet-count-card">
                                        <div class="icons">
                                            <i class="fas fa-bullseye"></i>
                                        </div>
                                        <div>
                                            <h4 class="number-counter"><?php echo $countExpectedAmt; ?></h4>
                                            <div>Expected</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sprachjet-count-card-box bg-danger-subtle">
                                <div class="product-name-details">
                                    <div class="card-content wallet-count-card">
                                        <div class="icons">
                                            <i class="fas fa-money-check"></i>
                                        </div>
                                        <div>
                                            <h4 class="number-counter"><?php echo $totalPayableAmount; ?></h4>
                                            <div>Payable</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sprachjet-count-card-box bg-success-subtle">
                                <div class="product-name-details">
                                    <div class="card-content wallet-count-card">
                                        <div class="icons">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <div>
                                            <h4 class="number-counter"><?php echo $countPaidAmt; ?></h4>
                                            <div>Paid</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sprachjet-count-card-box bg-success-subtle">
                                <div class="product-name-details">
                                    <div class="card-content wallet-count-card">
                                        <div class="icons">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div>
                                            <h4 class="number-counter"><?php echo $countPaidAmt; ?></h4>
                                            <div>Wallet Balance</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i = 1;
                        if($transationList->have_posts()) : ?>
                            <div class="card-comman-box">
                                <h2 class="title-comman">Transation List</h2>
                            </div>
                            <div class="card-comman-box">
                                <div class="table-responsive">
                                    <table class="table comman-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Lead Id</th>
                                                <th>Student Name</th>
                                                <th>Course</th>
                                                <th>Status</th>
                                                <th>Remark</th>
                                                <th>Payment</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($transationList->have_posts()) : $transationList->the_post(); ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php the_id();?></td>
                                                <td><?php echo get_post_meta(get_the_ID(), 'first_name', true).' '.get_post_meta(get_the_ID(), 'last_name', true); ?> </td>
                                                <td><?php echo get_post_meta(get_the_ID(), 'priority', true); ?></td>
                                                <td><?php echo get_post_meta(get_the_ID(), 'application_status', true); ?></td>
                                                <td><?php echo get_post_meta(get_the_ID(), 'remark', true); ?></td>
                                                <td><?php $paid_amount = get_post_meta(get_the_ID(), 'payable_amount', true); echo array_sum($paid_amount); ?></td>
                                                
                                            </tr>
                                            <?php $i++; endwhile; wp_reset_postdata(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-wallet" role="tabpanel" aria-labelledby="v-pills-wallet-tab">
                    <div class="dashboard-box-screen">
                        <div class="card-comman-box profile-box">
                            <div class="teacher-profile-page">
                                <div class="teacher-profile-details">
                                    <div class="teacher-details" id="partner-details">
                                        <div class="teacher-profile-img" id="partner_img">
                                            <?php $pro_img = ( get_user_meta($current_user_id, 'profile_image_url', true) ? get_user_meta($current_user_id, 'profile_image_url', true) : "https://sprachjet.com/wp-content/uploads/2024/05/img_avatar.png"); ?>
                                            <img src="<?php echo $pro_img; ?>" />
                                            <div class="profile-msg" style="color: red;"></div>
                                            <!--<label class="form-label" >Profile Pic.(jpeg,jpg,png and gif)</label>-->

                                            <div class="techer-profile-edit-area">
                                                <button type="button" class="edit_partner_profile btn btn-primary" ><i class="far fa-edit"></i></button>
                                            </div>
                                            </div>
                                        <div class="teacher-name">
                                            <?php $first_name = get_user_meta($current_user_id, 'first_name', true);
                                            $last_name = get_user_meta($current_user_id, 'last_name', true); ?>
                                            <h4 id="partner_name"><?php echo $first_name.' '.$last_name; ?></h4>
                                            <p id="partner_phone">Mob. : <?php echo get_user_meta($current_user_id, 'phone_number', true); ?></p>
                                            <p id="partner_email">Email : <?php echo get_user_meta($current_user_id, 'email', true); ?></p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <form name="partner-profile-edit" id="partner-profile-edit" method="post" enctype="multipart/form-data"> 
        
                            <div class="card-comman-box comman-form-box">
                                <div class="comman-tab-head mb-3">
                                    <h4>Basic Details</h4>
                                </div>
                                <input type="file" class="form-control" name="profilepic" id="profilepic" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                      <div class="create-lead-floating form-floating">
                                        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="pfirst_name" value="<?php echo get_user_meta($current_user_id, 'first_name', true); ?>">
                                        <label class="form-label">First name  <span class="text-danger">*</span></label>
                                        <div class="error pfirst_name-msg" style="color: red;"></div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="create-lead-floating form-floating">
                                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="plast_name" value="<?php echo get_user_meta($current_user_id, 'last_name', true); ?>">
                                        <label class="form-label">Last name</label>
                                        <div class="error plast_name-msg" style="color: red;"></div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="create-lead-floating form-floating">
                                        <input type="text" class="form-control" placeholder="Email" name="email" id="pemail" value="<?php echo get_user_meta($current_user_id, 'email', true) ?>">
                                        <label class="form-label">Email  <span class="text-danger">*</span></label>
                                        <div class="error pemail-msg" style="color: red;"></div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="create-lead-floating form-floating">
                                        <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="pmobile" value="<?php echo get_user_meta($current_user_id, 'phone_number', true); ?>">
                                        <label class="form-label">Mobile Number  <span class="text-danger">*</span></label>
                                        <div class="error pphone-msg" style="color: red;"></div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-comman-box comman-form-box">
                                <div class="comman-tab-head mb-3">
                                    <h4>Address</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="<?php echo get_user_meta($current_user_id, 'billing_address_1', true); ?>" />
                                            <label class="form-label">Address</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="create-lead-floating form-floating">
                                            <?php $pstate = get_user_meta($current_user_id, 'billing_state', true); ?>
                                                <input type="hidden" name="partner_sts_value" id="partner_sts_value" value="<?php echo $pstate; ?>"/>
                                                <select onchange="print_city('city_value', this.selectedIndex);" id="partner_sts" name ="partner_sts" class="form-control"></select>
                                                <script language="javascript">print_state("partner_sts");</script>
                                                <label class="form-label">state</label>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="create-lead-floating form-floating">
                                            <?php $city = get_user_meta($current_user_id, 'billing_city', true); ?>
                                            <input type="hidden" name="partner_city_value" id="partner_city_value" value="<?php echo $city; ?>"/>
                                            <select id ="city_value" class="form-control" name="city" value=""></select>
                                            <label class="form-label">Town.City</label>
                                            
                                            
                                        </div>
                                    </div>
    
                                    
                                    <div class="col-md-4">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Zip Code" name="zipcode" id="zipcode" value="<?php echo get_user_meta($current_user_id, 'billing_postcode', true); ?>" />
                                            <label class="form-label">Zip Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Landmarks" name="landmark" id ="landmark" value="<?php echo get_user_meta($current_user_id, 'landmark', true); ?>" />
                                            <label class="form-label">Nearby/Landmarks</label>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-4">-->
                                    <!--    <div class="create-lead-floating form-floating">-->
                                    <!--        <input type="text" class="form-control" placeholder="Country" name="countryid" value="" />-->
                                    <!--        <label class="form-label">Country</label>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>
    
                            <div class="card-comman-box comman-form-box">
                                <div class="comman-tab-head mb-3">
                                    <h4>Documents</h4>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Pan Card" name="pancard" id="pancard" value="<?php echo get_user_meta($current_user_id, 'pancard_no', true); ?>" />
                                            <label class="form-label">Pan Card</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Aadhaar Card" name="adharcard" id="adharcard" value="<?php echo get_user_meta($current_user_id, 'adharcard_no', true); ?>" />
                                            <label class="form-label">Aadhaar Card</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <?php $penimg = ( ( get_user_meta($current_user_id, 'pencard_img_url', true) ) ? get_user_meta($current_user_id, 'pencard_img_url', true) : "https://sprachjet.com/wp-content/uploads/2024/05/card.php_.png" );  ?>
                                            <img class="preview pencard_img" src="<?php echo $penimg;  ?>">
                                            <div class="mb-3"></div>
                                            <div class="teacher-personal-doc-update">
                                                <input type="file" class="form-control" name="pancardfie"  id="pancardfie"/>
                                                <div class="pancardfie-msg" style="color: red;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <?php $adharimg = ( ( get_user_meta($current_user_id, 'pencard_img_url', true) ) ? get_user_meta($current_user_id, 'asharcard_img_url', true) : "https://sprachjet.com/wp-content/uploads/2024/05/card.php_.png" );  ?>
                                            <img class="preview adharcard_img" src="<?php echo $adharimg;  ?>">
                                            <div class="mb-3"></div>
                                            <div class="teacher-personal-doc-update">
                                                <input type="file" class="form-control" name="adharcardfile" id="adharcardfile"/>
                                                <div class="adharcardfile-msg" style="color: red;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="card-comman-box comman-form-box">
                                <div class="comman-tab-head mb-3">
                                    <h4>Bank Details</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Account Number" name="account_number" id="account_number" value="<?php echo get_user_meta($current_user_id, 'account_number', true); ?>" />
                                            <label class="form-label">Account Number <span class="text-danger">*</span></label>
                                            <div class="error account_number-msg" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Bank Name" name="Bankname" id="Bankname" value="<?php echo get_user_meta($current_user_id, 'bankname', true); ?>" />
                                            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                                            <div class="error bankname-msg" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="Branch Name" name="branchname" id="branchname" value="<?php echo get_user_meta($current_user_id, 'branchname', true); ?>" />
                                            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                                            <div class="error branchname-msg" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="create-lead-floating form-floating">
                                            <input type="text" class="form-control" placeholder="IFSC Code" name="ifsc_code" id="ifsc_code" value="<?php echo get_user_meta($current_user_id, 'ifsc_code', true); ?>" />
                                            <label class="form-label">Ifsc Code <span class="text-danger">*</span></label>
                                            <div class="error ifsc_code-msg" style="color: red;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
    
                            <div class="comman-btn d-flex justify-content-between mt-3">
                                <!--<button class="btn btn-moec btn-secondary" type="reset"><i class="fas fa-undo"></i>-->
                                <!--  Reset</button>-->
                                <button class="btn btn-moec btn-primary" type="submit" onclick=""><i class="fas fa-check"></i>
                                  &nbsp; Submit</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
            
          
        </div>
    </div>
    </div>
    
</div>

<?php while ($students_query->have_posts()) : $students_query->the_post(); ?>

    <div class="modal fade student-comman-modal edit_std_model" id="edit-student-details<?php the_ID(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Basic Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="notification_container" style="display: none;"></div>
                <form method="POST" action="/partner-dashboard" class="fromt-desk-form-student-info needs-validation edit-student" role="form" data-id="<?php the_ID(); ?>" id="edit-student<?php the_ID(); ?>" enctype="multipart/form-data">
                    <input name="std_id" type="hidden" value="<?php the_ID(); ?>" >
                    <div class="modal-body">
                        <div class="comman-form-box row">
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="text" class="form-control" placeholder="First Name" value="<?php echo get_field('first_name'); ?>" name="first_name" id="first_name<?php the_ID(); ?>" />
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <div class="error first_name-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="text" class="form-control" placeholder="Last Name" value="<?php echo get_field('last_name'); ?>" name="last_name" id="last_name<?php the_ID(); ?>" />
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <div class="error last_name-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <select class="form-control" name="gender" id="gender<?php the_ID(); ?>">
                                        <option value="">Choose...</option>
                                        <option value="Male" <?php if(get_field('gender') == "Male") {  echo "selected"; } ?>>Male</option>
                                        <option value="Female" <?php if(get_field('gender') == "Female") {  echo "selected"; } ?>>Female</option>
                                        <option value="Other" <?php if(get_field('gender') == "Other") {  echo "selected"; } ?>>Other</option>
                                    </select>
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <div class="error gender-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="front-desk-form-input-group input-group telInput">
                                   
    
                                    <div class="create-lead-floating form-floating">
                                        <input type="tel" class="form-control" name="phone_no<?php the_ID(); ?>" value="<?php echo get_field('phone_no'); ?>" id="phone_no<?php the_ID(); ?>" placeholder="Phone no. *" />
                                     
                                        <div class="error phone-msg<?php the_ID(); ?>" style="color: red;"></div>
                                    </div>
                                                                        
    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="email" class="form-control" placeholder="Email" name="email" id="email<?php the_ID(); ?>" value="<?php echo get_field('email'); ?>" />
                                    <label class="form-label">Email </label>
                                    <div class="error email-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="hidden" name="edit_state" class="edit_state" value="<?php echo get_field('mailing_state'); ?>">
                                    <select onchange="print_city('state<?php the_ID(); ?>', this.selectedIndex);" id="sts<?php the_ID(); ?>" name="sts<?php the_ID(); ?>" class="form-control">
                                        
                                    </select>
                                    <script language="javascript">
                                        print_state("sts<?php the_ID(); ?>");
                                    </script>
                                    
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <div class="error StateList-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="hidden" name="edit_city" class="edit_city" value="<?php echo get_field('mailing_city'); ?>">
                                    <select id="state<?php the_ID(); ?>" class="form-control" name="city" value="hkdskjd"></select>
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <div class="error CityList-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="create-lead-floating form-floating">
                                    <input type="text" class="form-control" placeholder="Zip Code" name="mailing_pincode" value="<?php echo get_field('mailing_pincode'); ?>" id="mailing_pincode<?php the_ID(); ?>" />
                                    <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                    <div class="error mailing_pincode-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <div class="create-lead-floating form-floating">
                                
                                    <select class="form-control" name="priority"  id="referfor<?php the_ID(); ?>" aria-label="Default select example">
                                        <option value="">----Select----</option>
                                        <option value="German Language" <?php if(get_field('priority') == "German Language") {  echo "selected"; } ?>>German Language</option>
                                        <option value="IELTS" <?php if(get_field('priority') == "IELTS") {  echo "selected"; } ?>>IELTS</option>
                                        <option value="Nursing Job in Germany" <?php if(get_field('priority') == "Nursing Job in Germany") {  echo "selected"; } ?>> Nursing Job in Germany</option>
                                        <option value="Ausbildung" <?php if(get_field('priority') == "Ausbildung") {  echo "selected"; } ?>>Ausbildung</option>
                                        <option value="Spanish" <?php if(get_field('priority') == "Spanish") {  echo "selected"; } ?>>Spanish</option>
                                        <option value="French" <?php if(get_field('priority') == "French") {  echo "selected"; } ?>>French</option>
                                        <option value="Other" <?php if(get_field('priority') == "Other") {  echo "selected"; } ?>>Other</option>
                                    </select>
                                        <label class="form-label">Refer For </label>
                                    <div class="error mailing_priority-msg<?php the_ID(); ?>" style="color: red;"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="create-lead-floating form-floating">
                                    <?php $applicationStatus =  get_post_meta(get_the_ID(), 'application_status', true); ?>
                                    <select name="application_status" class="application_status" id="application_status<?php the_ID(); ?>">
                                        <option value="Pending" <?php if($applicationStatus == "Pending") { echo "selected"; } ?>>Pending</option>
                                        <option value="In Progress" <?php if($applicationStatus == "In Progress") { echo "selected"; } ?>>In Progress</option>
                                        <option value="In Discussion" <?php if($applicationStatus == "In Discussion") { echo "selected"; } ?>>In Discussion</option>
                                        <option value="Registration Done" <?php if($applicationStatus == "Registration Done") { echo "selected"; } ?>>Registration Done</option>
                                        <option value="Lead Converted" <?php if($applicationStatus == "Lead Converted") { echo "selected"; } ?>>Lead Converted</option>
                                        <option value="Fee Deposited" <?php if($applicationStatus == "Fee Deposited") { echo "selected"; } ?>>Fee Deposited</option>
                                    </select>
                                    
                                    <div class="error app-status-msg" style="color: red;"></div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="create-lead-floating form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" name="remark" id="remark<?php the_ID(); ?>"><?php echo get_field('remark'); ?></textarea>
                                    <label for="floatingTextarea2">Status Note</label>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="modal-footer">
               <!--          <button class="btn btn-default" onclick="resetForm()" type="reset"><i class="fas fa-sync-alt"></i> Reset</button> -->
                        <button class="btn btn-primary" type="submit"name="editsubmitbtn" id="submitbtn"><i class="fas fa-check"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endwhile; wp_reset_postdata(); ?>


<!-- Modal -->
<div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <form name="quickedit" id="quickedit" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        
            <div class="row comman-form-box">
            <div class="col-md-12">
              <div class="create-lead-floating form-floating">
                <input type="text" class="form-control" placeholder="First Name" name="first_name" id="pfirst_name" value="<?php echo get_user_meta($current_user_id, 'first_name', true); ?>">
                <label class="form-label">First name  <span class="text-danger">*</span></label>
                <div class="pfirst_name-msg" style="color: red;"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="create-lead-floating form-floating">
                <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="plast_name" value="<?php echo get_user_meta($current_user_id, 'last_name', true); ?>">
                <label class="form-label">Last name</label>
                <div class="plast_name-msg" style="color: red;"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="create-lead-floating form-floating">
                <input type="text" class="form-control" placeholder="Email" name="email" id="pemail" value="<?php echo get_user_meta($current_user_id, 'user_email', true) ?>">
                <label class="form-label">Email  <span class="text-danger">*</span></label>
                <div class="pemail-msg" style="color: red;"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="create-lead-floating form-floating">
                <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="pmobile" value="<?php echo get_user_meta($current_user_id, 'phone_number', true); ?>">
                <label class="form-label">Mobile Number  <span class="text-danger">*</span></label>
                <div class="pphone-msg" style="color: red;"></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="create-lead-floating form-floating">
                <div class="teacher-personal-doc-update">
                  <label class="form-label" >Profile Pic.(jpeg,jpg,png and gif)</label>
                  <input type="file" class="form-control" name="profilepic" id="profilepic">
                  <div class="profile-msg" style="color: red;"></div>
                </div>
              </div>
            </div>
          </div>
        
      </div>
       <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >Update</button>
            </div>
        </div>
        </form>
  </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade student-comman-modal" id="student-basic-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Student Basic Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="notification_container" style="display: none;"></div>
            <form method="POST" action="" class="fromt-desk-form-student-info needs-validation" role="form" id="create-student" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="VLbh8GuknBf5Gn2dWneM6tXFQ4DaunyScfScSfjp" />
                <div class="modal-body">
                    <div class="comman-form-box row">
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="text" class="form-control" placeholder="First Name" value="" name="first_name" id="first_name" />
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <div class="error first_name-msg" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="text" class="form-control" placeholder="Last Name" value="" name="last_name" id="last_name" />
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <div class="error last_name-msg" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <div class="error gender-msg" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="front-desk-form-input-group input-group telInput">
                               

                                <div class="create-lead-floating form-floating">
                                    <input type="tel" class="form-control" name="phone_no" id="phone_no" placeholder="Phone no. *" />
                                 
                                    <div class="error phone-msg" style="color: red;"></div>
                                </div>
                                                                    

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="email" class="form-control" placeholder="Primary Email" name="email" id="email" value="" />
                                <label class="form-label">Email </label>
                                <div class="error email-msg" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <select onchange="print_city('state', this.selectedIndex);" id="sts" name="sts" class="form-control"></select>
                                <script language="javascript">
                                    print_state("sts");
                                </script>

                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <div class="error StateList-msg" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <select id="state" class="form-control" name="city"></select>
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <div class="error CityList-msg" style="color: red;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="text" class="form-control" placeholder="Zip Code" name="mailing_pincode" id="mailing_pincode" />
                                <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                <div class="error mailing_pincode-msg" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="create-lead-floating form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="remark" id="addremark"></textarea>
                                <label for="floatingTextarea2">Other/Remarks</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="create-lead-floating form-floating">
                            
                                <select class="form-control" name="priority" aria-label="Default select example">
                                    <option value="">----Select----</option>
                                    <option value="German Language">German Language</option>
                                    <option value="IELTS">IELTS</option>
                                    <option value="Nursing Job in Germany"> Nursing Job in Germany</option>
                                    <option value="Ausbildung">Ausbildung</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="French">French</option>
                                    <option value="Other">Other</option>
                                </select>
                                    <label class="form-label">Refer For </label>
                                <div class="error mailing_priority-msg" style="color: red;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
           <!--          <button class="btn btn-default" onclick="resetForm()" type="reset"><i class="fas fa-sync-alt"></i> Reset</button> -->
                    <button class="btn btn-primary" type="submit" id="formsubmitbtn"><i class="fas fa-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="confirmationModal" class="modal fade student-comman-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to update the post?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="post-update-btn">
                <button id="confirmYes">Yes</button>
                <button id="confirmNo">No</button>
            </div>
            
        </div>
    </div>
</div>

<div id="viewmoreModal" class="modal fade student-comman-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="main_content">
                
            </div>
            
        </div>
    </div>
</div>

<!--payment form-->
<div class="modal fade student-comman-modal" id="student-payment-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Student Basic Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="notification_container" style="display: none;"></div>
            <form method="POST" action="/partner-dashboard" class="fromt-desk-form-student-info needs-validation" role="form" id="payment-student" enctype="multipart/form-data">
                <input name="std_id" type="hidden" value="" />
                <input name="paid_amt" type="hidden" value="" />
                <div class="modal-body">
                    <div class="comman-form-box row">
                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="text" class="form-control" placeholder="Expected Amount" value="" name="expected_amount" id="expected_amount" />
                                <label class="form-label">Expected Amount<span class="text-danger">*</span></label>
                                <div class="error expected_amount-msg" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="create-lead-floating form-floating">
                                <input type="text" class="form-control" placeholder="Payable Amount" value="" name="payable_amount" id="payable_amount" />
                                <label class="form-label">Payable Amount</label>
                                <div class="error payable_amount-msg" style="color: red;"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="modal-footer">
           <!--          <button class="btn btn-default" onclick="resetForm()" type="reset"><i class="fas fa-sync-alt"></i> Reset</button> -->
                    <button class="btn btn-primary" type="submit" name="pay_submit" id="payformsubmitbtn" disabled><i class="fas fa-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
get_footer();?>



