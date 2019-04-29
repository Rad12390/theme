<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'frank_jewelry_store_wp_gdpr_compliance_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'frank_jewelry_store_wp_gdpr_compliance_theme_setup9', 9 );
	function frank_jewelry_store_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'frank_jewelry_store_filter_tgmpa_required_plugins', 'frank_jewelry_store_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'frank_jewelry_store_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	function frank_jewelry_store_wp_gdpr_compliance_tgmpa_required_plugins($list=array()) {
		if (in_array('wp-gdpr-compliance', frank_jewelry_store_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('WP GDPR Compliance', 'frank-jewelry-store'),
				'slug' 		=> 'wp-gdpr-compliance',
				'required' 	=> false
			);
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'frank_jewelry_store_exists_wp_gdpr_compliance' ) ) {
	function frank_jewelry_store_exists_wp_gdpr_compliance() {
		return class_exists( 'WPGDPRC\WPGDPRC' );
	}
}
