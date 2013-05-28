<?php
/*
Plugin Name: Metaphor Galleries
Description: Adds a custom post type to easily create media galleries to add to your site. Add a gallery archive or single gallery to any page with shortcodes.
Version: 1.0.4
Author: Metaphor Creations
Author URI: http://www.metaphorcreations.com
License: GPL2
*/

/*
Copyright 2012 Metaphor Creations  (email : joe@metaphorcreations.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Fugue Icons

Copyright (C) 2011 Yusuke Kamiyamane. All rights reserved.
The icons are licensed under a Creative Commons Attribution
3.0 license. <http://creativecommons.org/licenses/by/3.0/>

<http://p.yusukekamiyamane.com/>
*/




/**Define Widget Constants */
if ( WP_DEBUG ) {
	define ( 'MTPHR_GALLERIES_VERSION', '1.0.4-'.time() );
} else {
	define ( 'MTPHR_GALLERIES_VERSION', '1.0.4' );
}
define ( 'MTPHR_GALLERIES_DIR', plugin_dir_path(__FILE__) );
define ( 'MTPHR_GALLERIES_URL', plugins_url().'/mtphr-galleries' );




add_action( 'plugins_loaded', 'mtphr_galleries_localization' );
/**
 * Setup localization
 *
 * @since 1.0.0
 */
function mtphr_galleries_localization() {
  load_plugin_textdomain( 'mtphr-galleries', false, 'mtphr-galleries/languages/' );
}




// Load the general functions
require_once( MTPHR_GALLERIES_DIR.'includes/scripts.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/post-types.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/taxonomies.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/functions.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/widget.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/shortcodes.php' );
require_once( MTPHR_GALLERIES_DIR.'includes/metaboxer/metaboxer.php' );

// Load the admin functions - @since 1.0
if ( is_admin() ) {

	require_once( MTPHR_GALLERIES_DIR.'includes/metaboxer/metaboxer-class.php' );
	require_once( MTPHR_GALLERIES_DIR.'includes/meta-boxes.php' );
	require_once( MTPHR_GALLERIES_DIR.'includes/settings.php' );
}




register_activation_hook( __FILE__, 'mtphr_galleries_activation' );
/**
 * Register the post type & flush the rewrite rules
 *
 * @since 1.0.0
 */
function mtphr_galleries_activation() {
	mtphr_galleries_posttype();
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'mtphr_galleries_deactivation' );
/**
 * Flush the rewrite rules
 *
 * @since 1.0.0
 */
function mtphr_galleries_deactivation() {
	flush_rewrite_rules();
}



