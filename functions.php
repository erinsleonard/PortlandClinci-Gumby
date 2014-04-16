<?php

	//Set the content width based on the theme's design and stylesheet.
	 if ( ! isset( $content_width ) )
		$content_width = 600; /* pixels */


	if ( ! function_exists( 'gp_theme_setup' ) ) :
	function gp_theme_setup() {

		//Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		//Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		//Register A WordPress Nav Menu
		register_nav_menus( array(
			'primary' => ( 'Primary Menu' ),
		) );

	}
	endif;
	add_action( 'after_setup_theme', 'gp_theme_setup' );



	//Register A Sidebar Widget
	function gp_widgets_init() {
	    register_sidebar( array(
	        'name' => ( 'Right Sidebar' ),
	        'description'   => 'The Right sidebar',
	        'class'         => '',
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h6 class="widget-title"> ',
	        'after_title' => ' </h6>',
	    ) );
	}
	add_action( 'widgets_init', 'gp_widgets_init' );



	//Enqueue all the required stylesheet and javascript files
	function gp_load_style_scripts() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	    wp_register_script('modernizr', get_template_directory_uri().'/js/modernizr-2.6.2.min.js','1.0', 'all');
		wp_register_script('gumby', get_template_directory_uri().'/js/gumby.min.js','1.0', 'all', true);

	    wp_enqueue_script(  'modernizr');
	    wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'gumby' );

		wp_register_style('gumby', get_template_directory_uri().'/css/gumby.css','1.0', 'all');


	    wp_enqueue_style( 'gumby' );
		wp_enqueue_style( 'style', get_stylesheet_uri() );

	}
	add_action( 'wp_enqueue_scripts', 'gp_load_style_scripts' );

	//Walker Class - This add support for the dropdown menu in the Gumbyframework
	class Walker_Page_Custom extends Walker_Nav_menu{

		function start_lvl(&$output, $depth=0, $args=array()){
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<div class=\"dropdown\"><ul>\n";
		}

		function end_lvl(&$output , $depth=0, $args=array()){
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul></div>\n";
		}
	}


	// custom stuffs here 
	// Register Custom Post Type
function doctors_custom_post_type() {

	$labels = array(
		'name'                => _x( 'Doctors', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Doctor', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Doctors', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Doctors', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'doctors_post_type', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		// 'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'doctors_post_type', $args );

}

// Hook into the 'init' action
add_action( 'init', 'doctors_custom_post_type', 0 );

// Register Custom Post Type
function locations_custom_post_type() {

	$labels = array(
		'name'                => _x( 'Locations', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Locations', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Locations', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'add_new_item'        => __( 'Add New Location', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'locations_post_type', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		// 'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'locations_post_type', $args );

}

// Hook into the 'init' action
add_action( 'init', 'locations_custom_post_type', 0 );

// Register Custom Post Type
function specialties_custom_post_type() {

	$labels = array(
		'name'                => _x( 'Specialties', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Specialty', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Specialties', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'spec_post_type', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'spec_post_type', $args );

}

// Hook into the 'init' action
add_action( 'init', 'specialties_custom_post_type', 0 );

