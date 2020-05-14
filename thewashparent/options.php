<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * option framework: https://github.com/devinsays/options-framework-theme
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	global $typography_mixed_fonts;

	// Test data
	$test_array = array(
		'Zero' => __('Zero', 'options_framework_theme'),
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	$cycle_fx = array(
		'fade' => __('fade', 'options_framework_theme'),
		'fadeout' => __('fadeout', 'options_framework_theme'),
		'none' => __('hero shot only', 'options_framework_theme'),
		'scrollHorz' => __('scrollHorz', 'options_framework_theme')
	);

		// Test data
	$responsive_array = array(
		'one' => __('Mobile Friendly', 'options_framework_theme'),
		'two' => __('Responsive', 'options_framework_theme'),
	);

	$cycle_pause = array(
		'true' => __('True', 'options_framework_theme'),
		'false' => __('False', 'options_framework_theme'),
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Array
	$footermenu_array = array(
		'none' => __('None', 'options_framework_theme'),
		'left' => __('Left', 'options_framework_theme'),
		'right' => __('Right', 'options_framework_theme'),
		'center' => __('Center', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	$fixed_scroll = array("fixed" => "Fixed","sticky" => "Sticky");

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '22px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#3c3c3c' );

	$typography_defaults_main = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'normal',
		'color' => '#3c3c3c' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	//This setting is for the wisiwig editor
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	// Multicheck Defaults
	$typography_weights = array(
		'300' => '300',
		'400' => '400 - normal',
		'500' => '500',
		'600' => '600',
		'700' => '700 - bold',
		'800' => '800',
	);

	$slider_numbers = array(
		'1' => __('1', 'options_framework_theme'),
		'2' => __('2', 'options_framework_theme'),
		'3' => __('3', 'options_framework_theme'),
		'4' => __('4', 'options_framework_theme'),
		'5' => __('5', 'options_framework_theme'),
		'6' => __('6', 'options_framework_theme'),
		'7' => __('7', 'options_framework_theme'),
		'8' => __('8', 'options_framework_theme'),
		'9' => __('9', 'options_framework_theme'),
		'10' => __('10', 'options_framework_theme')
		);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

$options[] = array(
		'name' => __('Typography', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array( "name" => "H1 Headings",
						"desc" => "Used in H1 tags.",
						"id" => "heading_h1_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);


	$options[] = array( "name" => "H2-H6 Headings",
						"desc" => "Used in H2-H6 tags.",
						"id" => "heading_h2_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);
/*
	$options[] = array( "name" => "H3 Headings",
						"desc" => "Used in H3 tags.",
						"id" => "heading_h3_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);

	$options[] = array( "name" => "H4 Headings",
						"desc" => "Used in H4 tags.",
						"id" => "heading_h4_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);

	$options[] = array( "name" => "H5 Headings",
						"desc" => "Used in H5 tags.",
						"id" => "heading_h5_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);

	$options[] = array( "name" => "H6 Headings",
						"desc" => "Used in H6 tags.",
						"id" => "heading_h6_typography",
						"std" => $typography_defaults,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);
*/					
	$options[] = array( "name" => "Main Body Text",
						"desc" => "Used in P tags.",
						"id" => "main_body_typography",
						"std" => $typography_defaults_main,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);
						
	$options[] = array( "name" => "Link Color",
						"desc" => "This is your main link colors.",
						"id" => "link_color",
						"std" => "#0645AD",
						"type" => "color");
					
	$options[] = array( "name" => "Link:hover Color",
						"desc" => "This is your hover state on your links.",
						"id" => "link_hover_color",
						"std" => "#0B0080",
						"type" => "color");
						
	$options[] = array( "name" => "Link:active Color",
						"desc" => "This is your active state on your links. This color should be the same color as your hover state.",
						"id" => "link_active_color",
						"std" => "#0B0080",
						"type" => "color");

$options[] = array(
		'name' => __('Social Media', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Facebook', 'options_framework_theme'),
		'desc' => __('Your Facebook Public URL', 'options_framework_theme'),
		'id' => 'facebook_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Twitter', 'options_framework_theme'),
		'desc' => __('Your Twitter Public URL', 'options_framework_theme'),
		'id' => 'twitter_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Google+', 'options_framework_theme'),
		'desc' => __('Your Google+ Public URL', 'options_framework_theme'),
		'id' => 'googleplus_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Linkedin', 'options_framework_theme'),
		'desc' => __('Your Linkedin Public URL', 'options_framework_theme'),
		'id' => 'Linkedin_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Youtube', 'options_framework_theme'),
		'desc' => __('Your Youtube Public URL', 'options_framework_theme'),
		'id' => 'youtube_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Vimeo', 'options_framework_theme'),
		'desc' => __('Your Vimeo Public URL', 'options_framework_theme'),
		'id' => 'vimeo_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Pinterest', 'options_framework_theme'),
		'desc' => __('Your Pinterest Public URL', 'options_framework_theme'),
		'id' => 'Pinterest_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Instagram', 'options_framework_theme'),
		'desc' => __('Your Instagram Public URL', 'options_framework_theme'),
		'id' => 'instagram_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Email', 'options_framework_theme'),
		'desc' => __('Your Public Mailto Email', 'options_framework_theme'),
		'id' => 'email_url',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Phone', 'options_framework_theme'),
		'desc' => __('Your Public Phone Number in 8012582585 Format', 'options_framework_theme'),
		'id' => 'phone_url',
		'std' => '',
		'type' => 'text');
	$options[] = array( 
		"name" => "Rss Feed",
		"desc" => "Show RSS Feed",
		"id" => "rss_social_media",
		"std" => "",
		"type" => "checkbox");

$options[] = array(
		'name' => __('Header', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array( "name" => "Branding Logo",
						"desc" => "Select an image to use for site branding",
						"id" => "branding_logo",
						"std" => "",
						"type" => "upload");

	$options[] = array( "name" => "Favicon",
						"desc" => "URL for a valid .ico or .png favicon",
						"id" => "favicon_logo",
						"std" => "",
						"type" => "upload");

	$options[] = array( "name" => "Main Navigation Text",
						"desc" => "Used in main header navagation.",
						"id" => "header_nav_typography",
						"std" => $typography_defaults_main,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);
						
	$options[] = array( "name" => "Main Navigation Hover Text Color",
						"desc" => "Main navigation hover color.",
						"id" => "top_nav_link_hover_color",
						"std" => "#000000",
						"type" => "color");

	$options[] = array( "name" => "Sub Navigation Text",
						"desc" => "Used in sub header navagation.",
						"id" => "header_nav_sub_typography",
						"std" => "typography_defaults_sub",
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);

	$options[] = array( "name" => "Sub Navigation Hover Text Color",
						"desc" => "Sub navigation link hover color.",
						"id" => "top_sub_link_hover_color",
						"std" => "#000000",
						"type" => "color");

	$options[] = array( "name" => "Breadcrumbs",
						"desc" => "Show breadcrumbs below the header",
						"id" => "header_breadcrumb",
						"std" => "",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Search bar",
						"desc" => "Show search bar in the header",
						"id" => "header_search_bar",
						"std" => "",
						"type" => "checkbox");

	$options[] = array( "name" => "Social Media",
						"desc" => "Show Social Media in the header",
						"id" => "header_social_media",
						"std" => "1",
						"type" => "checkbox");

	$options[] = array( "name" => "Social Media Color",
						"desc" => "Default is used if no color is selected.",
						"id" => "social_media_header_link_color",
						"std" => "#3c3c3c",
						"type" => "color");

	$options[] = array(
						'name' => __('Header Call To Action', 'options_framework_theme'),
						'desc' => __('This area is usually in the top right corner of the header.', 'options_framework_theme'),
						'id' => 'call_to_action_editor',
						'type' => 'editor',
						'settings' => $wp_editor_settings );

	

$options[] = array(
		'name' => __('Footer', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array( "name" => "Footer Navigation Text",
						"desc" => "Used for the navigation in the footer",
						"id" => "footer_nav_typography",
						"std" => $typography_defaults_main,
						"type" => "typography",
						'options' => array(
        					'faces' => $typography_mixed_fonts )
					);
						
	$options[] = array( "name" => "Footer Nav Hover Color",
						"desc" => "Footer navigation hover color",
						"id" => "footer_nav_link_hover_color",
						"std" => "#000000",
						"type" => "color");

	$options[] = array( "name" => "Search Bar",
						"desc" => "Show search bar in footer",
						"id" => "footer_search_bar",
						"std" => "",
						"type" => "checkbox");

	$options[] = array( "name" => "Social Media",
						"desc" => "Show Social Media in footer",
						"id" => "footer_social_media",
						"std" => "1",
						"type" => "checkbox");

	$options[] = array( "name" => "Social Media Color",
						"desc" => "Default is used if no color is selected.",
						"id" => "social_media_footer_link_color",
						"std" => "#3c3c3c",
						"type" => "color");

	$options[] = array(
						'name' => __('Standard Navagation', 'options_framework_theme'),
						'desc' => __('Warning: Advance Feature Do NOT change. This is used to declare where the main footer navigation is used.', 'options_framework_theme'),
						'id' => 'footer_menu',
						'std' => 'left',
						'type' => 'radio',
						'options' => $footermenu_array);

	$options[] = array(
						'name' => __('Number of widgets in the footer', 'options_framework_theme'),
						'desc' => __('Warning: Advance Feature Do NOT change. This is used to declare an advanced footer.  The widgets are editable in the widgets section of wordpress.', 'options_framework_theme'),
						'id' => 'widget_number',
						'std' => 'four',
						'type' => 'select',
						'class' => 'mini', //mini, tiny, small
						'options' => $test_array);

	$options[] = array(
						'name' => __('Footer Call To Action', 'options_framework_theme'),
						'desc' => __('This area is usually on the right side of the footer.', 'options_framework_theme'),
						'id' => 'call_to_action_footer',
						'type' => 'editor',
						'settings' => $wp_editor_settings );

	

$options[] = array(
		'name' => __('Advanced Layout Setting', 'options_framework_theme'),
		'type' => 'heading');
/*
	$options[] = array( "name" => "Header Position",
						"desc" => "Fixed to the top of the window (sticky) or scroll with content (fixed).",
						"id" => "nav_position",
						"std" => "Fixed",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $fixed_scroll);

	$options[] = array(
						'name' => __('Sticky Header Height', 'options_framework_theme'),
						'desc' => __('when sticky is selected a height in PX has to be here', 'options_framework_theme'),
						'id' => 'sticky_header_height',
						'std' => '150px',
						"class" => "mini", //mini, tiny, small
						'type' => 'text');
*/
	$options[] = array( "name" => "Social Media Colors",
						"desc" => "Use the social media colors instead of the color listed below",
						"id" => "footer_social_color",
						"std" => "",
						"type" => "checkbox");

	$options[] = array( "name" => "Comments",
						"desc" => "Toggle comments on pages, posts, etc. (leave unchecked to keep comments on the site)",
						"id" => "comments",
						"std" => "",
						"type" => "checkbox");

	$options[] = array( 'name' => __('Shortcode Option 1', 'options_framework_theme'),
						'desc' => __('Use [shortcode_option_1] anywhere, to pull in this textbox. html and js only', 'options_framework_theme'),
						'id' => 'shortcode_option_1',
						'std' => '',
						'type' => 'textarea');

	$options[] = array(	'name' => __('Shortcode Option 2', 'options_framework_theme'),
						'desc' => __('Use [shortcode_option_2] anywhere, to pull in this textbox. html and js only', 'options_framework_theme'),
						'id' => 'shortcode_option_2',
						'std' => '',
						'type' => 'textarea');

	$options[] = array(	'name' => __('Shortcode Option 3', 'options_framework_theme'),
						'desc' => __('Use [shortcode_option_3] anywhere, to pull in this textbox. html and js only', 'options_framework_theme'),
						'id' => 'shortcode_option_3',
						'std' => '',
						'type' => 'textarea');

	$options[] = array(
						'name' => "Default Layout For Pages And Plugins",
						'desc' => "This can be overwritten inside of the page via the Page Attributes.",
						'id' => "example_images",
						'std' => "1col-fixed",
						'type' => "images",
						'options' => array(
							'1col-fixed' => $imagepath . '1col.png',
							'2c-l-fixed' => $imagepath . '2cl.png',
							'2c-r-fixed' => $imagepath . '2cr.png')
					);
	$options[] = array(
						'name' => "Default Layout For Blog",
						'desc' => "This cannot be overwritten inside of the individual blog page",
						'id' => "example_images_blog",
						'std' => "2c-r-fixed",
						'type' => "images",
						'options' => array(
							'1col-fixed' => $imagepath . '1col.png',
							'2c-l-fixed' => $imagepath . '2cl.png',
							'2c-r-fixed' => $imagepath . '2cr.png')
					);
	$options[] = array(
						'name' => "Default Layout For Woocommerce",
						'desc' => "Pages like the cart, checkout, and my account is still controlled inside of the page via the Page Attributes.",
						'id' => "example_images_woo",
						'std' => "1col-fixed",
						'type' => "images",
						'options' => array(
							'1col-fixed' => $imagepath . '1col.png',
							'2c-l-fixed' => $imagepath . '2cl.png',
							'2c-r-fixed' => $imagepath . '2cr.png')
					);
	$options[] = array( 'name' => __('Header Scripts ', 'options_framework_theme'),
						'desc' => __('', 'options_framework_theme'),
						'id' => 'header_scripts',
						'std' => '',
						'type' => 'textarea');
	$options[] = array( 'name' => __('Footer Scrips', 'options_framework_theme'),
						'desc' => __('', 'options_framework_theme'),
						'id' => 'footer_scripts',
						'std' => '',
						'type' => 'textarea');

$options[] = array(
		'name' => __('White Label Options', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array( "name" => "Branding Logo",
						"desc" => "Select an image to use for site branding",
						"id" => "reseller_branding_logo",
						"std" => "",
						"type" => "upload");

	$options[] = array( "name" => "Branding Favicon",
						"desc" => "URL for a valid .ico or .png favicon",
						"id" => "reseller_favicon_logo",
						"std" => "",
						"type" => "upload");
    $options[] = array(
						'name' => __('URL', 'options_framework_theme'),
						'desc' => __('Your reseller public url', 'options_framework_theme'),
						'id' => 'reseller_url',
						'std' => '',
						'type' => 'text');
    $options[] = array(
						'name' => __('Name', 'options_framework_theme'),
						'desc' => __('Your reseller public name', 'options_framework_theme'),
						'id' => 'reseller_name',
						'std' => '',
						'type' => 'text');


$options[] = array(
		'name' => __('Home Page Slider', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array( "name" => "Slider FX",
						"desc" => "How the slider behaves. For a hero shot select hero shot only.",
						"id" => "cycle_fx",
						"std" => "fadeout",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $cycle_fx);

	$options[] = array( "name" => "Pause On Hover",
						"desc" => "",
						"id" => "cycle_pause",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $cycle_pause);

	$options[] = array( "name" => "Pagination",
						"desc" => "Put pagination on the slider",
						"id" => "pagination",
						"std" => "",
						"type" => "checkbox");

	$options[] = array( "name" => "Navigation Arrows",
						"desc" => "Put navigation arrows on the slider",
						"id" => "nav-arrows",
						"std" => "",
						"type" => "checkbox");

	$options[] = array(
						'name' => __('Slider Transitions', 'options_framework_theme'),
						'desc' => __('Transitions between slides (in milliseconds) default is 1000', 'options_framework_theme'),
						'id' => 'cycle_speed',
						'std' => '1000',
						"class" => "mini", //mini, tiny, small
						'type' => 'text');

	$options[] = array(
						'name' => __('Slider Speed', 'options_framework_theme'),
						'desc' => __('Time between slides (in milliseconds) default is 8000', 'options_framework_theme'),
						'id' => 'Cycle_timeout',
						'std' => '8000',
						"class" => "mini", //mini, tiny, small
						'type' => 'text');
       /* $options[] = array(
						'name' => __('Slider Amount', 'options_framework_theme'),
						'desc' => __('number of sliders', 'options_framework_theme'),
						'id' => 'slider_amount',
						'std' => '1',
						"class" => "mini", //mini, tiny, small
						'type' => 'text');
		*/
        $options[] = array( "name" => "Slider Amount",
						"desc" => "How many sliders do you want.",
						"id" => "slider_amount",
						"std" => "1",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" =>  $slider_numbers);

//first image
        $slideramount = (int)of_get_option('slider_amount', 0);
        //echo apply_filters('the_content', of_get_option( 'Slider_amount', 'no entry'));
      
        for($i = 1; $i <= $slideramount; $i++){
        $options[] = array( 
        	"name" => "Slider {$i} Image",
			"desc" => "Select an image to use for Slider $i",
			"id" => "slider_{$i}_image",
			"std" => "",
			"type" => "upload");

		$options[] = array(
			'name' => __("Slider {$i} link Tag", "options_framework_theme"),            
			'desc' => __('valid link: example: http://google.com/', 'options_framework_theme'),
			'id' => "slider_{$i}_link",
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __("Slider {$i} Content", 'options_framework_theme'),
			'desc' => __("This area is used for content slider {$i}", 'options_framework_theme'),
			'id' => "slider_{$i}_content",
			'type' => 'editor',
			'settings' => $wp_editor_settings );

        $options[] = array(
            'name' => __("Slider {$i} Order", "options_framework_theme"),
            'desc' => __('Slider Order', 'options_framework_theme'),
            'id' => "slider_{$i}_order",
            'std' => '',
            'type' => 'text');

        $options[] = array(
            "name" =>__("Slider {$i} Delete", "options_framework_theme"),
            "desc" => __('Slider Delete', 'options_framework_theme'),
            "id" => "slider_{$i}_delete",
            "std" => "",
            "type" => "checkbox");

        }

	
	return $options;
}