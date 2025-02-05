<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Edubin
 * Version: 1.0.0
 */

?>

<div class="footer-top">
    <div class="container">
		<div class="footer-top-inner">
			
		
			
			<div class="row footer-top-content">
			<div class="col-md-6">
				<div class="footer-top-inner-left">
			<?php dynamic_sidebar('sidebar-logo'); ?>
				</div>
				</div>
				<div class="col-md-6">
				<div class="footer-top-inner-right">
					<?php dynamic_sidebar('sidebar'); ?>
					</div>
				</div>
				
</div>
		</div>
		
        <div class="row footer-wrap">
            <div class="col-lg-3 col-md-6 <?php if ( is_active_sidebar( 'footer-1' ) ) : echo esc_attr( 'sidebar-yes' ); else : echo esc_attr( 'sidebar-no' ); endif; ?>">
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-1' ); ?>     
                </div>
             </div>
            <div class="col-lg-3 col-md-6 <?php if ( is_active_sidebar( 'footer-2' ) ) : echo esc_attr( 'sidebar-yes' ); else : echo esc_attr( 'sidebar-no' ); endif; ?>">
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-2' ); ?>     
                </div>
             </div>
            <div class="col-lg-3 col-md-6 <?php if ( is_active_sidebar( 'footer-3' ) ) : echo esc_attr( 'sidebar-yes' ); else : echo esc_attr( 'sidebar-no' ); endif; ?>">
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-3' ); ?>     
                </div>
             </div>
            <div class="col-lg-3 col-md-6  <?php if ( is_active_sidebar( 'footer-4' ) ) : echo esc_attr( 'sidebar-yes' ); else : echo esc_attr( 'sidebar-no' ); endif; ?>">
                <div class="footer-column">
                    <?php dynamic_sidebar( 'footer-4' ); ?>     
                </div>
             </div>
        </div>
    </div>
</div>