<?php

/**
 * The template for displaying all single venues.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header(); 
wp_enqueue_script ( 'nanogallery-js');
wp_enqueue_script ( 'slick-js');
wp_enqueue_script ( 'jquery-min-js');


?> 

<div >
	<?php
		//set pub count
		set_single_pub_view_count();
		$post_id 				= get_the_ID();
		$map_api_key 			= get_field('gmap_api_key', 'option');
		$pub_address          = get_field('pub_address');
		$pub_contact_info          = get_field('pub_contact_info');
		$open_hours          = get_field('open_hours');
			$weekdays = get_sub_field('weekdays');
			
		$photos_video          = get_field('photos_video');
		$catering_and_dining          = get_field('catering_and_dining');
		$policies          = get_field('policies');
		$technology          = get_field('technology');
		$foodbeverage_additionalinfo          = get_field('foodbeverage_additionalinfo');
		$rates          = get_field('rates');
		$ParkingSpace          = get_field('ParkingSpace');
		$ParkingSpace          = get_field('ParkingSpace');
		$video_tube          = get_sub_field('video_tube');
		
		
		
    ?>
	<div class="pub-back-section">
		<div class="row">
			<div class="col-7 col-xs-12 arrow-bar"><?php 
				if( isset( $_SERVER['HTTP_REFERER'] ) ){
					$prev_page = $_SERVER['HTTP_REFERER'];
				}else{
					$prev_page = '#';
				}?>
				<a class="back-link" href="<?php echo $prev_page; ?>">
					<span class="fa-stack fa-1x">
						<i class="fas fa-circle fa-stack-2x"></i>
						<i class="fas fa-chevron-left fa-stack-1x fa-inverse"></i>
					</span>
				</a>
				<span class="back-title"><?php the_title(); ?></span>
			</div>
			<div class="col col-xs-12 quote-bar">
				<ul class="pub-top-icons">
					<li><span class="inner-icon"><?php echo do_shortcode( '[addtoany]' ); ?></span></li>
					<li class="phoneIcon"><span class="inner-icon"><a href="callto:<?php echo $phone_number ?>"><i class="fa fa-solid fa-phone"></i></a></span></li>
					<li><?php the_favorites_button($post_id); ?></li>
					<li class="pub-quote-btn"><a href="#quick-quote-btn" class="elementor-button-link elementor-button elementor-size-sm elementor-button-link">Get a Quote</a></li>
				</ul>

			</div>
		</div>
	</div>
	<div class="pub-image-gallery">
		<?php if($photos_video || $video_tube ){?>
		<div id="venue-gallery">
			<?php 
				$pub_images = $photos_video['slideshow_photos'];
				$venue_videos = $video_tube;
			
				// Venue Images
				$pub_images_initial = $pub_images;
				if( $pub_images_initial ): ?>
					<?php foreach( $pub_images_initial as $pub_image_initial ): ?>
						<a href="<?php echo esc_url($pub_image_initial['url']); ?>">
							<img class="no-lazy" src="<?php echo esc_url($pub_image_initial['sizes']['large']); ?>" alt="<?php echo esc_attr($pub_image_initial['alt']); ?>" />
						</a>
					<?php endforeach; ?>
				<?php endif; ?>	

					<?php
						$pub_videos_initial = $venue_videos;
						if( $pub_videos_initial ) {
							foreach( $pub_videos_initial as $pub_video_initial ) { ?>
								  <a href="<?php echo $pub_video_initial['url']; ?>" data-ngthumb="<?php echo $pub_video_initial['url']; ?>"></a>

							<?php }
						}?>
		</div>
		<?php } ?>
	</div>
    <div class="custom-container">
		<div class="row">
		
			 <div class="right-side-single col-2 col-xs-12">
			 
			 <?php 
						echo do_shortcode('[searchandfilter id="946"]'); ?>
						
			 </div><!-- #col-4 -->
		
            <div class="left-side-single col-10 col-xs-12">
			
			<h1 class="venue-title"><?php the_title(); ?></h1>
            <ul class="venue-meta">
                    <?php if($pub_address['address'] || $pub_address['address_2'] || $pub_address['city'] || $pub_address['state'] || $pub_address['address_country'] || $pub_address['zip'] || $pub_address['location_field']){ ?>
						<li class="venue-meta-loc"><i class="icon ico-location">&nbsp;</i>
							<a href="#venue-address"><?php
								echo !empty($pub_address['address']) ? $pub_address['address'] . ', ' : '';
								echo !empty($pub_address['address_2']) ? $pub_address['address_2'] . ', ' : '';
								echo !empty($pub_address['city']) ? $pub_address['city'] . ', ' : '';
								echo !empty($pub_address['state']) ? $pub_address['state'] . ' ' : '';
								echo !empty($pub_address['address_country']) ? $pub_address['address_country'] . ' ' : '';
								echo !empty($pub_address['zip']) ? $pub_address['zip'] : '';
								echo !empty($pub_address['location_field']) ? $pub_address['location_field'] : '';
							?></a>
						</li>
					<?php } ?>
            </ul>
				
			<?php if (!empty($open_hours)) { ?>
			
			<div class="OpenHOurs">
				<h3><?php _e('Open Hours'); ?></h3>
				<p><strong>Weekdays</strong></p>
				<p><strong>Saturdays</strong></p>
				<p><strong>Sundays</strong></p>
				
			
			</div><!-- #Open Hours -->
			
			<?php } ?>
			
			
			<div>
				<h3>Menu and Dining</h3>
			
			</div><!-- #Menu and Dining -->
			
			
			<div>
				<h3>Contact Info</h3>
			
			</div><!-- Contact Info -->
				
				
			
			
			</div><!-- #col-8 -->
			
			
			
		</div><!-- #row -->
    </div>
	
	
	
 </div><!-- #primary -->
    
     <script type="text/javascript">
		
		    jQuery(document).ready(function($) {
			
			jQuery("#venue-gallery").nanogallery2({
			"galleryTheme" : "light",
			"galleryMosaic" :   [
				{ "c": 1, "r": 1, "w": 2, "h": 2 },
				{ "c": 3, "r": 1, "w": 1, "h": 1 },
				{ "c": 3, "r": 2, "w": 1, "h": 1 },
				{ "c": 4, "r": 1, "w": 1, "h": 1 },
				{ "c": 4, "r": 2, "w": 1, "h": 1 }
			],
			"galleryMosaicXS" :   [
				{ "c": 1, "r": 1, "w": 2, "h": 1 }
			],
			"galleryMaxRows": 1,
			"galleryDisplayMode": "rows",
			"thumbnailHeight":  "250 XS450",
			"thumbnailWidth":   "470 XS450",
			"thumbnailGutterWidth": "8", 
			"thumbnailGutterHeight": "8",
			"thumbnailBorderHorizontal": "0",
			"thumbnailBorderVertical": "0",
			"thumbnailAlignment": "fillWidth",
			"eventsDebounceDelay": "1000",
			"thumbnailSliderDelay": "0",
			"thumbnailLabel": {
				"display": false
			},
		});
		
		// Dining Slider
			$('.dining-slider').slick({
				dots: true,
				arrows: false,
				infinite: false,
				slidesToShow: 2,
				slidesToScroll: 2,
				responsive: [
							{
							  breakpoint: 600,
							  settings: {
								slidesToShow: 1,
  				  				slidesToScroll:1,
							  }
							}
						  ]
			});
			
			
			  // Testimonials Slider
            $('.testimonials-slider').slick({
				dots: true,
				arrows: false,
				infinite: false,
			});

        });
    </script>
	
	
    <?php 
	
	
	get_footer(); ?>