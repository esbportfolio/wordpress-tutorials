<?php

// Register menus
function register_menus() {
	register_nav_menus( array(
		'header-menu' => 'Header Menu',
	));
}

add_action( 'init', 'register_menus' );

// Add custom logo support
function add_custom_logo() {
	add_theme_support( 'custom-logo');
}

add_action( 'after_setup_theme', 'add_custom_logo' );

// Add stylesheets and scripts
function add_theme_scripts() {
	// Add Bootstrap style to header
	wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
	// Add your stylesheet to header--MUST go after Bootstrap so anything you add will trump any Bootstrap settings
	wp_enqueue_style( 'custom_css', get_stylesheet_uri() );
	// Add Bootstrap script just before closing </body> tag
	wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array(), false, true );
}

// Call the add_theme_scripts function when it's time to enqueue scripts
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );