<?php

/**
 * Enqueue parent and child styles
 */
function edubin_child_enqueue_styles() {
	wp_enqueue_style( 'edubin-parent', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'edubin-child', get_stylesheet_directory_uri() . '/style.css', array( 'edubin-parent' ) );

    wp_enqueue_style('data-tables-css', 'https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css');
    wp_enqueue_style('data-tables2-css', 'https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.dataTables.css');
    wp_enqueue_style('intlTelInput-css', 'https://cdn.jsdelivr.net/npm/intl-tel-input@21.1.4/build/css/intlTelInput.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('data-tables-js', 'https://cdn.datatables.net/2.0.3/js/dataTables.js', array('jquery'), null, true);
    wp_enqueue_script('data-tablesff-js', 'https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.js', array('jquery'), null, true);
    wp_enqueue_script('data-tabfflesff-js', 'https://cdn.datatables.net/rowgroup/1.5.0/js/rowGroup.dataTables.js', array('jquery'), null, true);
    wp_enqueue_script('data-intlTelInput-js', 'https://cdn.jsdelivr.net/npm/intl-tel-input@21.1.4/build/js/intlTelInput.min.js', array('jquery'), null, true);

	wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assest/js/custom.js', array('jquery'));
    wp_enqueue_script('cities-js', get_stylesheet_directory_uri() . '/assest/js/cities.js');
    wp_localize_script( 'custom-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')) );
    wp_enqueue_script('custom-js');
}

add_action( 'wp_enqueue_scripts', 'edubin_child_enqueue_styles', 11 );


 

function our_webinar( $atts ) {  
    ob_start();
    
    $query_args = array( 'post_type'=> 'our_webinar','posts_per_page'=> -1 ,'order'=> 'ASC');
    $fetch_data  = new WP_Query( $query_args );
    if($fetch_data->have_posts() !='')
    {
        $countslider = 1;
		?>
<div class="container">
<div class="row">
<?php
        while ( $fetch_data->have_posts() ) : $fetch_data->the_post();

            ?>
            <div class="col-md-4">
               <div class="our-webinar-inner">
                <figure><?php the_post_thumbnail( 'full' ); ?></figure>
                <div class="text-team-box">
                <h4><?php the_title(); ?></h4>
                <p><?php $content = get_the_content(); echo wp_trim_words( get_the_content(), 25, '...' );?></p>
				<a class="webinar-btn" href="#" data-post-url="<?php echo esc_url( get_permalink(get_the_ID()) ); ?>" data-post-id="<?php echo get_the_ID();?>">Watch Now</a>
                </div>
                
            </div>
</div>
            <?php

		$countslider++; endwhile; wp_reset_query(); ?></div></div> <?php
    }

    $stringa = ob_get_contents();
    ob_end_clean();
    return $stringa;
    }
    
add_shortcode("our_webinar_shortcode", "our_webinar");


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_stylesheet_directory() . '/inc/custom-functions.php';
