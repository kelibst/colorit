<?php
/**
 * Twenty Sixteen Customizer functionality
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Twenty Sixteen 1.0
 *
 * @see colorit_header_style()
 */
function colorit_custom_header_and_background() {
	$color_scheme             = colorit_get_color_scheme();
	$default_background_color = trim( $color_scheme[0], '#' );
	$default_text_color       = trim( $color_scheme[3], '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in Twenty Sixteen.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'colorit_custom_background_args', array(
		'default-color' => $default_background_color,
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Twenty Sixteen.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'colorit_custom_header_args', array(
		'default-text-color'     => $default_text_color,
		'width'                  => 1200,
		'height'                 => 280,
		'flex-height'            => true,
		'wp-head-callback'       => 'colorit_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'colorit_custom_header_and_background' );

if ( ! function_exists( 'colorit_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own colorit_header_style() function to override in a child theme.
 *
 * @see colorit_custom_header_and_background().
 */
function colorit_header_style() {
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="colorit-header-css">
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-branding .site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	</style>
	<?php
}
endif; // colorit_header_style

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function colorit_customize_register( $wp_customize ) {
	$color_scheme = colorit_get_color_scheme();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'colorit_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'colorit_customize_partial_blogdescription',
		) );
	}

	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'colorit_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'colorit' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => colorit_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// Add page background color setting and control.
	$wp_customize->add_setting( 'page_background_color', array(
		'default'           => $color_scheme[1],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_background_color', array(
		'label'       => __( 'Page Background Color', 'colorit' ),
		'section'     => 'colors',
	) ) );

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Add link color setting and control.
	$wp_customize->add_setting( 'link_color', array(
		'default'           => $color_scheme[2],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'       => __( 'Link Color', 'colorit' ),
		'section'     => 'colors',
	) ) );

	// Add main text color setting and control.
	$wp_customize->add_setting( 'main_text_color', array(
		'default'           => $color_scheme[3],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
		'label'       => __( 'Main Text Color', 'colorit' ),
		'section'     => 'colors',
	) ) );

	// Add secondary text color setting and control.
	$wp_customize->add_setting( 'secondary_text_color', array(
		'default'           => $color_scheme[4],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_text_color', array(
		'label'       => __( 'Secondary Text Color', 'colorit' ),
		'section'     => 'colors',
	) ) );

// adding social menu customizer link grabber

	$wp_customize->add_section( 'menu_links', array(
  'title' => __( 'Footer informations', 'colorit' ),
  'description' => __( 'Add footer informations here' ),
  'priority' => 200,
  'capability' => 'edit_theme_options',
) );

//setting for menu links

	$wp_customize->add_setting( 'menulinks_facebook', array(
  'default' => '#f',
  'type'	=> 'theme_mod'
) );

//controls for menu links
	$wp_customize->add_control( 'menulinks_facebook', array(
  'label' => __( 'Facebook link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 1
) );


//setting for menu twitter links

	$wp_customize->add_setting( 'menulinks_twitter', array(
  'default' => '#t',
  'type'	=> 'theme_mod'
) );

//controls for menu twitter links
	$wp_customize->add_control( 'menulinks_twitter', array(
  'label' => __( 'Twitter link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 2
) );


//setting for menu rss links

	$wp_customize->add_setting( 'menulinks_rss', array(
  'default' => '#r',
  'type'	=> 'theme_mod'
) );

//controls for menu rss links
	$wp_customize->add_control( 'menulinks_rss', array(
  'label' => __( 'RSS link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 3
) );



//setting for menu youtube links

	$wp_customize->add_setting( 'menulinks_youtube', array(
  'default' => '#y',
  'type'	=> 'theme_mod'
) );

//controls for menu youtube links
	$wp_customize->add_control( 'menulinks_youtube', array(
  'label' => __( 'Youtube link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 4
) );


//setting for menu linkedin links

	$wp_customize->add_setting( 'menulinks_linkedin', array(
  'default' => '#l',
  'type'	=> 'theme_mod'
) );

//controls for menu linkedin links
	$wp_customize->add_control( 'menulinks_linkedin', array(
  'label' => __( 'Linkedin link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 5
) );


//setting for menu google plus links

	$wp_customize->add_setting( 'menulinks_google+', array(
  'default' => '#g',
  'type'	=> 'theme_mod'
) );

//controls for menu google plus links
	$wp_customize->add_control( 'menulinks_google+', array(
  'label' => __( 'Google plus link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 6
) );


//setting for copyright info

	$wp_customize->add_setting( 'copy', array(
  'default' => 'Color iT Solutions &copy',
  'type'	=> 'theme_mod'
) );

//controls for copyright info
	$wp_customize->add_control( 'copy', array(
  'label' => __( 'Copyright information', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 7
) );


//setting for copyright info link

	$wp_customize->add_setting( 'copy_link', array(
  'default' => 'coloredit.org',
  'type'	=> 'theme_mod'
) );

//controls for copyright info
	$wp_customize->add_control( 'copy_link', array(
  'label' => __( 'Copyright link', 'colorit' ),
  'section' => 'menu_links',
  'priority' => 7
) );




// adding slider option in customizer

	$wp_customize->add_section( 'slider_options', array(
  'title' => __( 'Slider', 'colorit' ),
  'description' => __( 'Customizer the slider here...' ),
  'priority' => 202,
  'capability' => 'edit_theme_options',
) );



//setting for big taglines info link

	$wp_customize->add_setting( 'tagline1', array(
  'default' => 'This is our big Tagline!',
  'type'	=> 'theme_mod'
) );

//controls for taglines info
	$wp_customize->add_control( 'tagline1', array(
  'label' => __( 'Slider tagline', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 1
) );



//setting for big taglines2 

	$wp_customize->add_setting( 'tagline2', array(
  'default' => 'This is our big Tagline!',
  'type'	=> 'theme_mod'
) );

//controls for tagline 2 
	$wp_customize->add_control( 'tagline2', array(
  'label' => __( 'Slider tagline 2', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 2
) );


//setting for big slogan 1

	$wp_customize->add_setting( 'slogan1', array(
  'default' => 'Here\'s our small slogan!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 1
	$wp_customize->add_control( 'slogan1', array(
  'label' => __( 'Slider slogan 1', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 2
) );




//setting for big slogan 2

	$wp_customize->add_setting( 'slogan2', array(
  'default' => 'Here\'s our small slogan!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 2
	$wp_customize->add_control( 'slogan2', array(
  'label' => __( 'Slider slogan 2', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 3
) );


//setting for big slogan 3

	$wp_customize->add_setting( 'slogan3', array(
  'default' => 'Here\'s our small slogan!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 3
	$wp_customize->add_control( 'slogan3', array(
  'label' => __( 'Slider slogan 3', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 4
) );


//setting for big slogan 4

	$wp_customize->add_setting( 'slogan4', array(
  'default' => 'Here\'s our small slogan!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 4
	$wp_customize->add_control( 'slogan4', array(
  'label' => __( 'Slider slogan 4', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 5
) );


//setting for big left-aligne 1

	$wp_customize->add_setting( 'lalign', array(
  'default' => 'Left Aligned Caption',
  'type'	=> 'theme_mod'
) );

//controls for slogan 1
	$wp_customize->add_control( 'lalign', array(
  'label' => __( 'Slider lalign ', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 6
) );



//setting for big slogan 1

	$wp_customize->add_setting( 'ralign', array(
  'default' => 'Right Aligned Caption!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 1
	$wp_customize->add_control( 'ralign', array(
  'label' => __( 'Slider ralign', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 7
) );


//setting for slider image1

	$wp_customize->add_setting( 'slider_img1', array(
  'default' => get_bloginfo('template_directory').'/img/background1.jpg',
  'type'	=> 'theme_mod'
) );

//controls for slider image 1
	$wp_customize->add_control( new WP_Customize_Image_control ( $wp_customize, 'slider_img1', array(
  'label' => __( 'Slider image1', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 8
) ));



//setting for slider image2

	$wp_customize->add_setting( 'slider_img2', array(
  'default' => get_bloginfo('template_directory').'/img/background2.jpg',
  'type'	=> 'theme_mod'
) );

//controls for slider image 2
	$wp_customize->add_control( new WP_Customize_Image_control ( $wp_customize, 'slider_img2', array(
  'label' => __( 'Slider image2', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 9
) ));



//setting for slider image3

	$wp_customize->add_setting( 'slider_img3', array(
  'default' => get_bloginfo('template_directory').'/img/background3.jpg',
  'type'	=> 'theme_mod'
) );

//controls for slider image 3
	$wp_customize->add_control( new WP_Customize_Image_control ( $wp_customize, 'slider_img3', array(
  'label' => __( 'Slider image3', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 10
) ));



//setting for slider image4

	$wp_customize->add_setting( 'slider_img4', array(
  'default' => get_bloginfo('template_directory').'/img/background5.jpg',
  'type'	=> 'theme_mod'
) );

//controls for slider image 4
	$wp_customize->add_control( new WP_Customize_Image_control ( $wp_customize, 'slider_img4', array(
  'label' => __( 'Slider image4', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 11
) ));


//setting for parallax image

	$wp_customize->add_setting( 'parallax1', array(
  'default' => get_bloginfo('template_directory').'/img/background5.jpg',
  'type'	=> 'theme_mod'
) );

//controls for slider image 4
	$wp_customize->add_control( new WP_Customize_Image_control ( $wp_customize, 'parallax1', array(
  'label' => __( 'parallax images', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 12
) ));

//settings for parallax header 1
	$wp_customize->add_setting( 'parahead1', array(
  'default' => 'GET ONLINE!!!',
  'type'	=> 'theme_mod'
) );

//controls for slogan 2
	$wp_customize->add_control( 'parahead1', array(
  'label' => __( 'Parallax Header 1', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 13
) );


//settings for parallax subheader 1
	$wp_customize->add_setting( 'parasubhead1', array(
  'default' => 'Let\'s get you online the professional way',
  'type'	=> 'theme_mod'
) );

//controls for slogan 2
	$wp_customize->add_control( 'parasubhead1', array(
  'label' => __( 'Parallax subHeader 1', 'colorit' ),
  'section' => 'slider_options',
  'priority' => 14
) );


// adding features  section selection

	$wp_customize->add_section( 'icon_options', array(
  'title' => __( 'Features', 'colorit' ),
  'description' => __( 'Customize the features section here...' ),
  'priority' => 201,
  'capability' => 'edit_theme_options',
) );


//settings for features section
	$wp_customize->add_setting( 'icon1', array(
  'default' => 'flash_on',
  'type'	=> 'theme_mod'
) );

//controls for features section 
	$wp_customize->add_control( 'icon1', array(
  'label' => __( 'Section feature icon1', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 1
) );


//settings for features section2
	$wp_customize->add_setting( 'icon2', array(
  'default' => 'group',
  'type'	=> 'theme_mod'
) );

//controls for features section 2
	$wp_customize->add_control( 'icon2', array(
  'label' => __( 'Section feature icon2', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 2
) );


//settings for features section 3
	$wp_customize->add_setting( 'icon3', array(
  'default' => 'settings',
  'type'	=> 'theme_mod'
) );

//controls for features section 3
	$wp_customize->add_control( 'icon3', array(
  'label' => __( 'Section feature icon3', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 3
) );

//settings for features subheader 1
	$wp_customize->add_setting( 'icon_head1', array(
  'default' => 'Speeds up development',
  'type'	=> 'theme_mod'
) );

//controls for features subheader 1
	$wp_customize->add_control( 'icon_head1', array(
  'label' => __( 'Subheader for icon section', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 4
) );



//settings for features subheader 2
	$wp_customize->add_setting( 'icon_head2', array(
  'default' => 'User Experience Focused',
  'type'	=> 'theme_mod'
) );

//controls for features subheader 2
	$wp_customize->add_control( 'icon_head2', array(
  'label' => __( 'Subheader for icon 2', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 5
) );



//settings for features subheader 1
	$wp_customize->add_setting( 'icon_head3', array(
  'default' => 'Easy to work with',
  'type'	=> 'theme_mod'
) );

//controls for features subheader 1
	$wp_customize->add_control( 'icon_head3', array(
  'label' => __( 'Subheader for icon 3', 'colorit' ),
  'section' => 'icon_options',
  'priority' => 6
) );



//settings for features textarea 1
	$wp_customize->add_setting( 'icon_tarea1', array(
  'default' => 'Easy to work with',
  'type'	=> 'theme_mod'
) );

//controls for features textarea 1
	$wp_customize->add_control( 'icon_tarea1', array(
  'label' => __( 'text for icon 3', 'colorit' ),
  'section' => 'icon_options',
  'type' => 'textarea',
  'priority' => 7
) );


//settings for features textarea 2
	$wp_customize->add_setting( 'icon_tarea2', array(
  'default' => 'Easy to work with',
  'type'	=> 'theme_mod'
) );

//controls for features textarea 1
	$wp_customize->add_control( 'icon_tarea2', array(
  'label' => __( 'text for icon 2', 'colorit' ),
  'section' => 'icon_options',
  'type' => 'textarea',
  'priority' => 8
) );


//settings for features textarea 1
	$wp_customize->add_setting( 'icon_tarea3', array(
  'default' => 'Easy to work with',
  'type'	=> 'theme_mod'
) );

//controls for features textarea 1
	$wp_customize->add_control( 'icon_tarea3', array(
  'label' => __( 'text for icon 3', 'colorit' ),
  'section' => 'icon_options',
  'type' => 'textarea',
  'priority' => 9
) );

}
add_action( 'customize_register', 'colorit_customize_register', 11 );
	



/**
 * Render the site title for the selective refresh partial.
 */
function colorit_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function colorit_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Registers color schemes for Twenty Sixteen.
 *
 * Can be filtered with {@see 'colorit_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Main Text Color.
 * 5. Secondary Text Color.
 *
 * @return array An associative array of color scheme options.
 */
function colorit_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with Twenty Sixteen.
	 *
	 * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'colorit_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'colorit' ),
			'colors' => array(
				'#1a1a1a',
				'#ffffff',
				'#007acc',
				'#1a1a1a',
				'#686868',
			),
		),
		'dark' => array(
			'label'  => __( 'Dark', 'colorit' ),
			'colors' => array(
				'#262626',
				'#1a1a1a',
				'#9adffd',
				'#e5e5e5',
				'#c1c1c1',
			),
		),
		'gray' => array(
			'label'  => __( 'Gray', 'colorit' ),
			'colors' => array(
				'#616a73',
				'#4d545c',
				'#c7c7c7',
				'#f2f2f2',
				'#f2f2f2',
			),
		),
		'red' => array(
			'label'  => __( 'Red', 'colorit' ),
			'colors' => array(
				'#ffffff',
				'#ff675f',
				'#640c1f',
				'#402b30',
				'#402b30',
			),
		),
		'yellow' => array(
			'label'  => __( 'Yellow', 'colorit' ),
			'colors' => array(
				'#3b3721',
				'#ffef8e',
				'#774e24',
				'#3b3721',
				'#5b4d3e',
			),
		),
	) );
}

if ( ! function_exists( 'colorit_get_color_scheme' ) ) :
/**
 * Retrieves the current Twenty Sixteen color scheme.
 *
 * Create your own colorit_get_color_scheme() function to override in a child theme.
 *
 * @return array An associative array of either the current or default color scheme HEX values.
 */
function colorit_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
	$color_schemes       = colorit_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}
endif; // colorit_get_color_scheme

if ( ! function_exists( 'colorit_get_color_scheme_choices' ) ) :
/**
 * Retrieves an array of color scheme choices registered for Twenty Sixteen.
 *
 * Create your own colorit_get_color_scheme_choices() function to override
 * in a child theme.
 *
 *
 * @return array Array of color schemes.
 */
function colorit_get_color_scheme_choices() {
	$color_schemes                = colorit_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}

	return $color_scheme_control_options;
}
endif; // colorit_get_color_scheme_choices


if ( ! function_exists( 'colorit_sanitize_color_scheme' ) ) :
/**
 * Handles sanitization for Twenty Sixteen color schemes.
 *
 * Create your own colorit_sanitize_color_scheme() function to override
 * in a child theme.
 */
function colorit_sanitize_color_scheme( $value ) {
	$color_schemes = colorit_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		return 'default';
	}

	return $value;
}
endif; // colorit_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function colorit_color_scheme_css() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

	// Don't do anything if the default color scheme is selected.
	if ( 'default' === $color_scheme_option ) {
		return;
	}

	$color_scheme = colorit_get_color_scheme();

	// Convert main text hex color to rgba.
	$color_textcolor_rgb = colorit_hex2rgb( $color_scheme[3] );

	// If the rgba values are empty return early.
	if ( empty( $color_textcolor_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		'background_color'      => $color_scheme[0],
		'page_background_color' => $color_scheme[1],
		'link_color'            => $color_scheme[2],
		'main_text_color'       => $color_scheme[3],
		'secondary_text_color'  => $color_scheme[4],
		'border_color'          => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $color_textcolor_rgb ),

	);

	$color_scheme_css = colorit_get_color_scheme_css( $colors );

	wp_add_inline_style( 'colorit-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'colorit_color_scheme_css' );

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since Twenty Sixteen 1.0
 */
function colorit_customize_control_js() {
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20160816', true );
	wp_localize_script( 'color-scheme-control', 'colorScheme', colorit_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'colorit_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Sixteen 1.0
 */
function colorit_customize_preview_js() {
	wp_enqueue_script( 'colorit-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20160816', true );
}
add_action( 'customize_preview_init', 'colorit_customize_preview_js' );

/**
 * Returns CSS for the color schemes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function colorit_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'background_color'      => '',
		'page_background_color' => '',
		'link_color'            => '',
		'main_text_color'       => '',
		'secondary_text_color'  => '',
		'border_color'          => '',
	) );

	return <<<CSS
	/* Color Scheme */

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}

	/* Page Background Color */
	.site {
		background-color: {$colors['page_background_color']};
	}

	mark,
	ins,
	button,
	button[disabled]:hover,
	button[disabled]:focus,
	input[type="button"],
	input[type="button"][disabled]:hover,
	input[type="button"][disabled]:focus,
	input[type="reset"],
	input[type="reset"][disabled]:hover,
	input[type="reset"][disabled]:focus,
	input[type="submit"],
	input[type="submit"][disabled]:hover,
	input[type="submit"][disabled]:focus,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.pagination .prev,
	.pagination .next,
	.pagination .prev:hover,
	.pagination .prev:focus,
	.pagination .next:hover,
	.pagination .next:focus,
	.pagination .nav-links:before,
	.pagination .nav-links:after,
	.widget_calendar tbody a,
	.widget_calendar tbody a:hover,
	.widget_calendar tbody a:focus,
	.page-links a,
	.page-links a:hover,
	.page-links a:focus {
		color: {$colors['page_background_color']};
	}

	/* Link Color */
	.menu-toggle:hover,
	.menu-toggle:focus,
	a,
	.main-navigation a:hover,
	.main-navigation a:focus,
	.dropdown-toggle:hover,
	.dropdown-toggle:focus,
	.social-navigation a:hover:before,
	.social-navigation a:focus:before,
	.post-navigation a:hover .post-title,
	.post-navigation a:focus .post-title,
	.tagcloud a:hover,
	.tagcloud a:focus,
	.site-branding .site-title a:hover,
	.site-branding .site-title a:focus,
	.entry-title a:hover,
	.entry-title a:focus,
	.entry-footer a:hover,
	.entry-footer a:focus,
	.comment-metadata a:hover,
	.comment-metadata a:focus,
	.pingback .comment-edit-link:hover,
	.pingback .comment-edit-link:focus,
	.comment-reply-link,
	.comment-reply-link:hover,
	.comment-reply-link:focus,
	.required,
	.site-info a:hover,
	.site-info a:focus {
		color: {$colors['link_color']};
	}

	mark,
	ins,
	button:hover,
	button:focus,
	input[type="button"]:hover,
	input[type="button"]:focus,
	input[type="reset"]:hover,
	input[type="reset"]:focus,
	input[type="submit"]:hover,
	input[type="submit"]:focus,
	.pagination .prev:hover,
	.pagination .prev:focus,
	.pagination .next:hover,
	.pagination .next:focus,
	.widget_calendar tbody a,
	.page-links a:hover,
	.page-links a:focus {
		background-color: {$colors['link_color']};
	}

	input[type="date"]:focus,
	input[type="time"]:focus,
	input[type="datetime-local"]:focus,
	input[type="week"]:focus,
	input[type="month"]:focus,
	input[type="text"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="password"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="number"]:focus,
	textarea:focus,
	.tagcloud a:hover,
	.tagcloud a:focus,
	.menu-toggle:hover,
	.menu-toggle:focus {
		border-color: {$colors['link_color']};
	}

	/* Main Text Color */
	body,
	blockquote cite,
	blockquote small,
	.main-navigation a,
	.menu-toggle,
	.dropdown-toggle,
	.social-navigation a,
	.post-navigation a,
	.pagination a:hover,
	.pagination a:focus,
	.widget-title a,
	.site-branding .site-title a,
	.entry-title a,
	.page-links > .page-links-title,
	.comment-author,
	.comment-reply-title small a:hover,
	.comment-reply-title small a:focus {
		color: {$colors['main_text_color']};
	}

	blockquote,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.post-navigation,
	.post-navigation div + div,
	.pagination,
	.widget,
	.page-header,
	.page-links a,
	.comments-title,
	.comment-reply-title {
		border-color: {$colors['main_text_color']};
	}

	button,
	button[disabled]:hover,
	button[disabled]:focus,
	input[type="button"],
	input[type="button"][disabled]:hover,
	input[type="button"][disabled]:focus,
	input[type="reset"],
	input[type="reset"][disabled]:hover,
	input[type="reset"][disabled]:focus,
	input[type="submit"],
	input[type="submit"][disabled]:hover,
	input[type="submit"][disabled]:focus,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.pagination:before,
	.pagination:after,
	.pagination .prev,
	.pagination .next,
	.page-links a {
		background-color: {$colors['main_text_color']};
	}

	/* Secondary Text Color */

	/**
	 * IE8 and earlier will drop any block with CSS3 selectors.
	 * Do not combine these styles with the next block.
	 */
	body:not(.search-results) .entry-summary {
		color: {$colors['secondary_text_color']};
	}

	blockquote,
	.post-password-form label,
	a:hover,
	a:focus,
	a:active,
	.post-navigation .meta-nav,
	.image-navigation,
	.comment-navigation,
	.widget_recent_entries .post-date,
	.widget_rss .rss-date,
	.widget_rss cite,
	.site-description,
	.author-bio,
	.entry-footer,
	.entry-footer a,
	.sticky-post,
	.taxonomy-description,
	.entry-caption,
	.comment-metadata,
	.pingback .edit-link,
	.comment-metadata a,
	.pingback .comment-edit-link,
	.comment-form label,
	.comment-notes,
	.comment-awaiting-moderation,
	.logged-in-as,
	.form-allowed-tags,
	.site-info,
	.site-info a,
	.wp-caption .wp-caption-text,
	.gallery-caption,
	.widecolumn label,
	.widecolumn .mu_register label {
		color: {$colors['secondary_text_color']};
	}

	.widget_calendar tbody a:hover,
	.widget_calendar tbody a:focus {
		background-color: {$colors['secondary_text_color']};
	}

	/* Border Color */
	fieldset,
	pre,
	abbr,
	acronym,
	table,
	th,
	td,
	input[type="date"],
	input[type="time"],
	input[type="datetime-local"],
	input[type="week"],
	input[type="month"],
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	input[type="tel"],
	input[type="number"],
	textarea,
	.main-navigation li,
	.main-navigation .primary-menu,
	.menu-toggle,
	.dropdown-toggle:after,
	.social-navigation a,
	.image-navigation,
	.comment-navigation,
	.tagcloud a,
	.entry-content,
	.entry-summary,
	.page-links a,
	.page-links > span,
	.comment-list article,
	.comment-list .pingback,
	.comment-list .trackback,
	.comment-reply-link,
	.no-comments,
	.widecolumn .mu_register .mu_alert {
		border-color: {$colors['main_text_color']}; /* Fallback for IE7 and IE8 */
		border-color: {$colors['border_color']};
	}

	hr,
	code {
		background-color: {$colors['main_text_color']}; /* Fallback for IE7 and IE8 */
		background-color: {$colors['border_color']};
	}

	@media screen and (min-width: 56.875em) {
		.main-navigation li:hover > a,
		.main-navigation li.focus > a {
			color: {$colors['link_color']};
		}

		.main-navigation ul ul,
		.main-navigation ul ul li {
			border-color: {$colors['border_color']};
		}

		.main-navigation ul ul:before {
			border-top-color: {$colors['border_color']};
			border-bottom-color: {$colors['border_color']};
		}

		.main-navigation ul ul li {
			background-color: {$colors['page_background_color']};
		}

		.main-navigation ul ul:after {
			border-top-color: {$colors['page_background_color']};
			border-bottom-color: {$colors['page_background_color']};
		}
	}

CSS;
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Twenty Sixteen 1.0
 */
function colorit_color_scheme_css_template() {
	$colors = array(
		'background_color'      => '{{ data.background_color }}',
		'page_background_color' => '{{ data.page_background_color }}',
		'link_color'            => '{{ data.link_color }}',
		'main_text_color'       => '{{ data.main_text_color }}',
		'secondary_text_color'  => '{{ data.secondary_text_color }}',
		'border_color'          => '{{ data.border_color }}',
	);
	?>
	<script type="text/html" id="tmpl-colorit-color-scheme">
		<?php echo colorit_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'colorit_color_scheme_css_template' );

/**
 * Enqueues front-end CSS for the page background color.
 *
 * @since Twenty Sixteen 1.0
 *
 * @see wp_add_inline_style()
 */
function colorit_page_background_color_css() {
	$color_scheme          = colorit_get_color_scheme();
	$default_color         = $color_scheme[1];
	$page_background_color = get_theme_mod( 'page_background_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $page_background_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Page Background Color */
		.site {
			background-color: %1$s;
		}

		mark,
		ins,
		button,
		button[disabled]:hover,
		button[disabled]:focus,
		input[type="button"],
		input[type="button"][disabled]:hover,
		input[type="button"][disabled]:focus,
		input[type="reset"],
		input[type="reset"][disabled]:hover,
		input[type="reset"][disabled]:focus,
		input[type="submit"],
		input[type="submit"][disabled]:hover,
		input[type="submit"][disabled]:focus,
		.menu-toggle.toggled-on,
		.menu-toggle.toggled-on:hover,
		.menu-toggle.toggled-on:focus,
		.pagination .prev,
		.pagination .next,
		.pagination .prev:hover,
		.pagination .prev:focus,
		.pagination .next:hover,
		.pagination .next:focus,
		.pagination .nav-links:before,
		.pagination .nav-links:after,
		.widget_calendar tbody a,
		.widget_calendar tbody a:hover,
		.widget_calendar tbody a:focus,
		.page-links a,
		.page-links a:hover,
		.page-links a:focus {
			color: %1$s;
		}

		@media screen and (min-width: 56.875em) {
			.main-navigation ul ul li {
				background-color: %1$s;
			}

			.main-navigation ul ul:after {
				border-top-color: %1$s;
				border-bottom-color: %1$s;
			}
		}
	';

	wp_add_inline_style( 'colorit-style', sprintf( $css, $page_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'colorit_page_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Twenty Sixteen 1.0
 *
 * @see wp_add_inline_style()
 */
function colorit_link_color_css() {
	$color_scheme    = colorit_get_color_scheme();
	$default_color   = $color_scheme[2];
	$link_color = get_theme_mod( 'link_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $link_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Link Color */
		.menu-toggle:hover,
		.menu-toggle:focus,
		a,
		.main-navigation a:hover,
		.main-navigation a:focus,
		.dropdown-toggle:hover,
		.dropdown-toggle:focus,
		.social-navigation a:hover:before,
		.social-navigation a:focus:before,
		.post-navigation a:hover .post-title,
		.post-navigation a:focus .post-title,
		.tagcloud a:hover,
		.tagcloud a:focus,
		.site-branding .site-title a:hover,
		.site-branding .site-title a:focus,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-footer a:hover,
		.entry-footer a:focus,
		.comment-metadata a:hover,
		.comment-metadata a:focus,
		.pingback .comment-edit-link:hover,
		.pingback .comment-edit-link:focus,
		.comment-reply-link,
		.comment-reply-link:hover,
		.comment-reply-link:focus,
		.required,
		.site-info a:hover,
		.site-info a:focus {
			color: %1$s;
		}

		mark,
		ins,
		button:hover,
		button:focus,
		input[type="button"]:hover,
		input[type="button"]:focus,
		input[type="reset"]:hover,
		input[type="reset"]:focus,
		input[type="submit"]:hover,
		input[type="submit"]:focus,
		.pagination .prev:hover,
		.pagination .prev:focus,
		.pagination .next:hover,
		.pagination .next:focus,
		.widget_calendar tbody a,
		.page-links a:hover,
		.page-links a:focus {
			background-color: %1$s;
		}

		input[type="date"]:focus,
		input[type="time"]:focus,
		input[type="datetime-local"]:focus,
		input[type="week"]:focus,
		input[type="month"]:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		input[type="tel"]:focus,
		input[type="number"]:focus,
		textarea:focus,
		.tagcloud a:hover,
		.tagcloud a:focus,
		.menu-toggle:hover,
		.menu-toggle:focus {
			border-color: %1$s;
		}

		@media screen and (min-width: 56.875em) {
			.main-navigation li:hover > a,
			.main-navigation li.focus > a {
				color: %1$s;
			}
		}
	';

	wp_add_inline_style( 'colorit-style', sprintf( $css, $link_color ) );
}
add_action( 'wp_enqueue_scripts', 'colorit_link_color_css', 11 );

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since Twenty Sixteen 1.0
 *
 * @see wp_add_inline_style()
 */
function colorit_main_text_color_css() {
	$color_scheme    = colorit_get_color_scheme();
	$default_color   = $color_scheme[3];
	$main_text_color = get_theme_mod( 'main_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $main_text_color === $default_color ) {
		return;
	}

	// Convert main text hex color to rgba.
	$main_text_color_rgb = colorit_hex2rgb( $main_text_color );

	// If the rgba values are empty return early.
	if ( empty( $main_text_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $main_text_color_rgb );

	$css = '
		/* Custom Main Text Color */
		body,
		blockquote cite,
		blockquote small,
		.main-navigation a,
		.menu-toggle,
		.dropdown-toggle,
		.social-navigation a,
		.post-navigation a,
		.pagination a:hover,
		.pagination a:focus,
		.widget-title a,
		.site-branding .site-title a,
		.entry-title a,
		.page-links > .page-links-title,
		.comment-author,
		.comment-reply-title small a:hover,
		.comment-reply-title small a:focus {
			color: %1$s
		}

		blockquote,
		.menu-toggle.toggled-on,
		.menu-toggle.toggled-on:hover,
		.menu-toggle.toggled-on:focus,
		.post-navigation,
		.post-navigation div + div,
		.pagination,
		.widget,
		.page-header,
		.page-links a,
		.comments-title,
		.comment-reply-title {
			border-color: %1$s;
		}

		button,
		button[disabled]:hover,
		button[disabled]:focus,
		input[type="button"],
		input[type="button"][disabled]:hover,
		input[type="button"][disabled]:focus,
		input[type="reset"],
		input[type="reset"][disabled]:hover,
		input[type="reset"][disabled]:focus,
		input[type="submit"],
		input[type="submit"][disabled]:hover,
		input[type="submit"][disabled]:focus,
		.menu-toggle.toggled-on,
		.menu-toggle.toggled-on:hover,
		.menu-toggle.toggled-on:focus,
		.pagination:before,
		.pagination:after,
		.pagination .prev,
		.pagination .next,
		.page-links a {
			background-color: %1$s;
		}

		/* Border Color */
		fieldset,
		pre,
		abbr,
		acronym,
		table,
		th,
		td,
		input[type="date"],
		input[type="time"],
		input[type="datetime-local"],
		input[type="week"],
		input[type="month"],
		input[type="text"],
		input[type="email"],
		input[type="url"],
		input[type="password"],
		input[type="search"],
		input[type="tel"],
		input[type="number"],
		textarea,
		.main-navigation li,
		.main-navigation .primary-menu,
		.menu-toggle,
		.dropdown-toggle:after,
		.social-navigation a,
		.image-navigation,
		.comment-navigation,
		.tagcloud a,
		.entry-content,
		.entry-summary,
		.page-links a,
		.page-links > span,
		.comment-list article,
		.comment-list .pingback,
		.comment-list .trackback,
		.comment-reply-link,
		.no-comments,
		.widecolumn .mu_register .mu_alert {
			border-color: %1$s; /* Fallback for IE7 and IE8 */
			border-color: %2$s;
		}

		hr,
		code {
			background-color: %1$s; /* Fallback for IE7 and IE8 */
			background-color: %2$s;
		}

		@media screen and (min-width: 56.875em) {
			.main-navigation ul ul,
			.main-navigation ul ul li {
				border-color: %2$s;
			}

			.main-navigation ul ul:before {
				border-top-color: %2$s;
				border-bottom-color: %2$s;
			}
		}
	';

	wp_add_inline_style( 'colorit-style', sprintf( $css, $main_text_color, $border_color ) );
}
add_action( 'wp_enqueue_scripts', 'colorit_main_text_color_css', 11 );

/**
 * Enqueues front-end CSS for the secondary text color.
 *
 * @since Twenty Sixteen 1.0
 *
 * @see wp_add_inline_style()
 */
function colorit_secondary_text_color_css() {
	$color_scheme    = colorit_get_color_scheme();
	$default_color   = $color_scheme[4];
	$secondary_text_color = get_theme_mod( 'secondary_text_color', $default_color );

	// Don't do anything if the current color is the default.
	if ( $secondary_text_color === $default_color ) {
		return;
	}

	$css = '
		/* Custom Secondary Text Color */

		/**
		 * IE8 and earlier will drop any block with CSS3 selectors.
		 * Do not combine these styles with the next block.
		 */
		body:not(.search-results) .entry-summary {
			color: %1$s;
		}

		blockquote,
		.post-password-form label,
		a:hover,
		a:focus,
		a:active,
		.post-navigation .meta-nav,
		.image-navigation,
		.comment-navigation,
		.widget_recent_entries .post-date,
		.widget_rss .rss-date,
		.widget_rss cite,
		.site-description,
		.author-bio,
		.entry-footer,
		.entry-footer a,
		.sticky-post,
		.taxonomy-description,
		.entry-caption,
		.comment-metadata,
		.pingback .edit-link,
		.comment-metadata a,
		.pingback .comment-edit-link,
		.comment-form label,
		.comment-notes,
		.comment-awaiting-moderation,
		.logged-in-as,
		.form-allowed-tags,
		.site-info,
		.site-info a,
		.wp-caption .wp-caption-text,
		.gallery-caption,
		.widecolumn label,
		.widecolumn .mu_register label {
			color: %1$s;
		}

		.widget_calendar tbody a:hover,
		.widget_calendar tbody a:focus {
			background-color: %1$s;
		}
	';

	wp_add_inline_style( 'colorit-style', sprintf( $css, $secondary_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'colorit_secondary_text_color_css', 11 );
