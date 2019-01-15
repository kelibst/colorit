<?php
/**
 * Twenty Nineteen functions and definitions
 */

//setting colorit theme

//if ( ! function_exists( 'colorit_setup' ) ) :

function coloritsetup () {

/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );


/* Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	

		/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'coloritsetup' );




/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';



/**
 * Registers a widget area.
 */
function coloritwidgets() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'colorit' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'colorit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="entry-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'colorit' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'colorit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'colorit' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'colorit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'coloritwidgets' );

	




// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'colorittheme' ),
				'footer' => __( 'Footer Menu', 'colorittheme' ),
				'social' => __( 'Social Links Menu', 'colorittheme' ),
			)
		);
		//enqueueing scripts
		function coloritscripts(){
			wp_enqueue_script('jquery-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.js', array('jquery'), '1.0', false  );

			wp_enqueue_script('materialize-js', get_template_directory_uri() . '/js/materialize.js', array('jquery'), '2.1.0', true  );
			

			// main themes style
			wp_enqueue_style( 'colorit-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
		//enqueue materialize css
			wp_enqueue_style( 'materialize-css', get_template_directory_uri() . '/css/materialize.css', array(), wp_get_theme()->get( 'Version' ) );

			wp_enqueue_style('materialize-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(),  wp_get_theme()->get( 'Version' ) );
		//enqueue needed fonts
			wp_enqueue_style( 'font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), wp_get_theme()->get( 'Version' ) );

			wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Carter+One|Charm|Charmonman|Dancing+Script|Lobster|Lobster+Two|Mountains+of+Christmas|Pacifico|Satisfy|Roboto', array(), wp_get_theme()->get( 'Version' ) );


			//enqueue scripts
			wp_enqueue_script('colorit-js', get_template_directory_uri() . '/js/init.js', array(), '1.0', false  );
			
		}
		add_action('wp_enqueue_scripts', 'coloritscripts');


/**
 * Enqueue editor styles for Gutenberg
 */
function colorit_block_editor_styles() {
	// Add custom fonts.
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Carter+One|Charm|Charmonman|Dancing+Script|Lobster|Lobster+Two|Mountains+of+Christmas|Pacifico|Satisfy', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'enqueue_block_editor_assets', 'colorit_block_editor_styles' );