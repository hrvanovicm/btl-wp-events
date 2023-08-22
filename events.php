<?php

/*
Plugin Name: Events
Plugin URI: https://www.github.com/hrvanovic/btl-wp-events
Description: Simple plugin for creating events.
Version: 1.0
Author: Mirza Hrvanovic
Author URI:  https://www.github.com/hrvanovic
License: MIT License
License URI: https://opensource.org/licenses/MIT
*/

class WPBTEvents {
	const PREFIX = 'wpbt_events_';
	const POST_TYPE = 'events';

	static function add() {
		register_post_type( 'events', array(
			'labels'        => array(
				'name'          => __( 'Dogadaji' ),
				'singular_name' => __( 'Dogadaj' )
			),
			'public'        => true,
			'show_in_rest'  => true,
			'supports'      => array( 'title', 'editor', 'thumbnail'),
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'events' ),
			'menu_position' => 2,
			'menu_icon'     => 'dashicons-calendar'
		) );
	}

	static function scripts() {
		wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css');
		wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js', array('jquery'), '', true);

		wp_enqueue_style('bootstrap-timepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css');
		wp_enqueue_script('bootstrap-timepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js', array('jquery'), '', true);

		wp_enqueue_script('jquery');
	}
}

add_action('init', ['WPBTEvents', 'add']);
add_action('admin_enqueue_scripts', ['WPBTEvents', 'scripts']);