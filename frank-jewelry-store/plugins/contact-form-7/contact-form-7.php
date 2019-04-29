<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('frank_jewelry_store_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'frank_jewelry_store_cf7_theme_setup9', 9 );
	function frank_jewelry_store_cf7_theme_setup9() {
		
		add_filter( 'frank_jewelry_store_filter_merge_scripts',	'frank_jewelry_store_cf7_merge_scripts');
		add_filter( 'frank_jewelry_store_filter_merge_styles',	'frank_jewelry_store_cf7_merge_styles' );

		if (frank_jewelry_store_exists_cf7()) {
			add_action( 'wp_enqueue_scripts',		'frank_jewelry_store_cf7_frontend_scripts', 1100 );
		}

		if (is_admin()) {
			add_filter( 'frank_jewelry_store_filter_tgmpa_required_plugins',	'frank_jewelry_store_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'frank_jewelry_store_cf7_tgmpa_required_plugins' ) ) {
	function frank_jewelry_store_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', frank_jewelry_store_storage_get('required_plugins'))) {
			// CF7 plugin
			$list[] = array(
				'name' 		=> esc_html__('Contact Form 7', 'frank-jewelry-store'),
				'slug' 		=> 'contact-form-7',
				'required' 	=> false
			);
			// CF7 extension - datepicker 

			$params = array(
					'name' 		=> esc_html__('Contact Form 7 Datepicker', 'frank-jewelry-store'),
					'slug' 		=> 'contact-form-7-datepicker',
					'required' 	=> false
				);
			$path = frank_jewelry_store_get_file_dir('plugins/contact-form-7/contact-form-7-datepicker.zip');
			if ($path != '')
				$params['source'] = $path;
			$list[] = $params;
		}
		return $list;
	}
}


// Check if cf7 installed and activated
if ( !function_exists( 'frank_jewelry_store_exists_cf7' ) ) {
	function frank_jewelry_store_exists_cf7() {
		return class_exists('WPCF7');
	}
}

// Enqueue custom scripts
if ( !function_exists( 'frank_jewelry_store_cf7_frontend_scripts' ) ) {
	function frank_jewelry_store_cf7_frontend_scripts() {
		if (frank_jewelry_store_exists_cf7()) {
			if (frank_jewelry_store_is_on(frank_jewelry_store_get_theme_option('debug_mode')) && ($frank_jewelry_store_url = frank_jewelry_store_get_file_url('plugins/contact-form-7/contact-form-7.js')) != '')
				wp_enqueue_script( 'frank_jewelry_store-cf7', $frank_jewelry_store_url, array('jquery'), null, true );
		}
	}
}
	
// Merge custom scripts
if ( !function_exists( 'frank_jewelry_store_cf7_merge_scripts' ) ) {
	function frank_jewelry_store_cf7_merge_scripts($list) {
		if (frank_jewelry_store_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}

// Merge custom styles
if ( !function_exists( 'frank_jewelry_store_cf7_merge_styles' ) ) {
	function frank_jewelry_store_cf7_merge_styles($list) {
		if (frank_jewelry_store_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}
?>