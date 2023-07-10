<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Property extends Composer
{
    protected static $views = [
        'partials.property.featured',
        'partials.property.loop-item',
        'partials.property.open-homes',
        'single-property',
    ];

    public function override()
    {
        return [
            'title' => $this->title(),
            'permalink' => $this->permalink(),
            'thumbnail' => $this->thumbnail(),
            'gallery' => $this->gallery(),
            'deadline' => $this->deadline(),
            'address' => $this->address(),
            'content' => $this->content(),
            'googleMap' => $this->googleMap(),
            'openHomes' => $this->openHomes(),
            'propertySection' => $this->propertySection(),
            'isSold' => $this->isSold(),
            'currentListingLink' => $this->currentListingLink(),
            'isViewingByAppointment' => $this->isViewingByAppointment(),
            'viewingByAppointmentContent' => $this->viewingByAppointmentContent(),
            'viewingByAppointmentForm' => $this->viewingByAppointmentForm(),
            'activateBannerWithImage' => $this->activateBannerWithImage(),
        ];
    }

    public function title()
    {
        return get_the_title();
    }

    public function content()
    {
        return get_the_content_by_id(get_the_ID());
    }

    public function permalink()
    {
        return get_permalink();
    }

    public function thumbnail()
    {
        $thumbnail = get_field('property_settings_feature_image');

        if (!$thumbnail) {
            $thumbnail = get_field('website_setup', 'option')['general_placeholder_image'];
        }

        return get_image_with_focus_on($thumbnail, 'thumbnail', 'large');
    }

    public function gallery()
    {
        $r = [];
    
        $video_default = \Roots\asset('images/video-default.png');
        $video_default = "<img src='$video_default' width='358' height='200' class='thumbnail object-cover object-center' />";
    
        $gallery = get_field('property_settings_gallery');
    
        if ($gallery) {
            foreach ($gallery as $item) {
                if ($item['type'] == 'image') {
                    $r[] = [
                        'thumbnail' => get_image_with_focus_on($item['ID'], 'thumbnail', 'medium'),
                        'view' => get_image_with_focus_on($item['ID'], 'thumbnail object-contain', 'massive'),
                    ];
                } else if ($item['type'] == 'video') {
                    $url = $item['url'];
                    $mime = $item['mime_type'];
                    $video = "<video class='object-cover video page-header-background thumbnail' autoplay muted loop><source src='$url' type='$mime' /></video>";
    
                    $r[] = [
                        'thumbnail' => $video_default,
                        'view' => $video,
                    ];
                }
            }
        }
    
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery("#gallery-slide").nanogallery2({
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
                    "thumbnailHeight":  "350 XS450",
                    "thumbnailWidth":   "670 XS450",
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
                    items: <?php echo json_encode($r); ?>
                });
            });
        </script>
        <?php
    
        return $r;
    }
    

    public function deadline()
    {
        return get_field('property_settings_deadline_sale');
    }

    public function activateBannerWithImage()
    {
        $acvate = get_field('banner_with_slide_property_activate', 'option');

        return isset($acvate[0]) && $acvate[0] == 'yes';
    }

    public function openHomes()
    {
        return get_field('property_settings_open_home_schedule');
    }
    public function propertySection()
    {
        return [
            'heading' => get_field('banner_with_slide_property_heading', 'option'),
            'background' => get_field('banner_with_slide_property_background', 'option'),
            'slides' => get_field('banner_with_slide_property_slides', 'option'),
        ];
    }

    public function isSold()
    {
        $sold = get_field('property_settings_sold');

        return isset($sold[0]) && $sold[0] == 'yes';
    }

    public function currentListingLink()
    {
        $website_setup = get_field('website_setup', 'option');
        return get_permalink($website_setup['linking_current_listings']);
    }

    public function isViewingByAppointment()
    {
        $sold = get_field('property_settings_viewing_by_appointment');

        return isset($sold[0]) && $sold[0] == 'yes';
    }

    public function viewingByAppointmentContent()
    {
        return get_field('property_viewing_by_appointment_content', 'option');
    }

    public function viewingByAppointmentForm()
    {
        return get_field('property_viewing_forminator_shortcode', 'option');
    }

    public function googleMap()
    {
        $map = get_field('property_settings_google_maps_iframe');

        if ($map) {
            $map = "<div class='embed-container'>$map</div>";
        }

        return $map;
    }

    public function address()
    {
        return get_field('property_settings_address');
    }

    public function attributes($attr_keys, $show_title = false)
    {
        $attributes = get_field('property_settings_attributes');

        $html = '';
        // $check = get_svg("images.attr-check");

        if ($attr_keys) {
            foreach ($attributes as $key => $value) {
                if (in_array($key, $attr_keys) && !empty($value)) {
                    $sufix = $key == 'building' ? 'm²' : '';
        
                    if ($key == 'land') {
                        $sufix = $attributes['land_unit'];
                    }
        
                    $svg = get_svg("images.attr-$key");
                            
                    $html .= "<p class='property-attr-item flex flex-col w-4/12 px-1 pb-3 justify-between items-center' aria-label='$key'>";
                    $html .= $svg;
                    if (isset($value[0]) && $value[0] == 'yes') {
                        $html .= "<span class='value text-lg mt-2'>✓</span>";
                    } else {
                        $html .= "<span class='value text-lg mt-2'>$value $sufix </span>";
                    }
                    if ($show_title) {
                        $title = $key;
        
                        if ($key == 'year_built') {
                            $title = 'year built';
                        } else if ($key == 'home_income') {
                            $title = 'home & income';
                        } else if ($key == 'sleep_out') {
                            $title = 'sleep out';
                        }
        
                        $html .= "<span class='attr-title mt-1 text-2xs color-darkAccent'>$title</span>";
                    }
                    $html .= "</p>";
                }
            }
        }
        

        return $html;
    }

    public function ctaListBlock()
    {
        return get_field('all_listing_cta_block', 'option');
    }


    public function createDate($date)
        {
            $date = str_replace('/', '-', $date);
            $timestamp = strtotime($date);

            return [
                'day' => date('j', $timestamp),
                'weekday' => date('l', $timestamp),
                'longDay' => date('jS F', $timestamp),
            ];
        }



    public function currentListingHeading()
    {
        return get_field('current_listing_heading', 'option');
    }

    public function currentListingCtaButton()
    {
        return get_field('current_listing_cta_button', 'option');
    }

    public function currentListingItems()
    {

        $number_of_properties = 7;

        $args = array(
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'property_settings_sold',
                    'value' => 'yes',
                    'compare' => 'NOT LIKE',
                ),
            ),
        );

        $query = new \WP_Query($args);
        $return = $query->posts;

        $post_count = $number_of_properties - $query->post_count;

        if ($post_count > 0) {
            $args = array(
                'post_type' => 'property',
                'post_status' => 'publish',
                'posts_per_page' => $post_count,
                'meta_query' => array(
                    array(
                        'key' => 'property_settings_sold',
                        'value' => 'yes',
                        'compare' => 'LIKE',
                    ),
                ),
            );

            $query = new \WP_Query($args);

            $return = array_merge($return, $query->posts);
        }

        return $return;

    }
}
