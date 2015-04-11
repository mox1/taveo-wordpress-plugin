<?php
/**
 * Plugin Name: Taveo Link Shortener
 * Plugin URI:  http://admin.taveo.net/extras/wp-plugin.html
 * Description: Provides an easy way to interface your WordPress site with Taveo click analytics.
 * Author:      Taveo
 * Author URI:  http://taveo.net/
 * Version:     1.0
 * License: 	GPL2
 *  
 */

/*  Copyright 2015 Taveo  (email : admin@taveo.net)

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
 
 
//Completed ajax base retrieval of data from taveo,and addition of button to the publish box.
//TODO : Enhance performace,if any and sort out any bugs.

/**
 * Define plugin constants
 */

//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );

// Plugin directory path and URL.
define( 'TAVEO_PLUGIN_DIR_PATH', dirname( __FILE__ ) );
define( 'TAVEO_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

// Plugin version
define( 'TAVEO_PLUGIN_VERSION', '1.0' );

define( 'TAVEO_API_CREATE_URL',  'https://api.taveo.net/1/create' );
define( 'TAVEO_API_OVERVIEW_URL',  'https://api.taveo.net/1/overview' );

// Verify SSL requests 
// Set to false during testing , true in production
define ('TAVEO_SSL_VERIFY', false);



/**
 * Load includes
 */
require( TAVEO_PLUGIN_DIR_PATH . '/includes/config_screen.php' );
require( TAVEO_PLUGIN_DIR_PATH . '/includes/add_to_taveo.php' );

/*Add all of our actions */
add_action('admin_menu', 'taveo_create_options_page');
add_action('admin_enqueue_scripts', 'taveo_enqueue_admin_js' );
add_action('init', 'get_pagepost_url' );



function taveo_create_options_page() { 
	$my_page=add_menu_page( 'Taveo','Taveo'  ,'manage_options','taveo_dashboard',
							'taveo_build_config_screen', plugin_dir_url( __FILE__ ) . 'includes/images/icon16.png' );
	add_action( 'load-' . $my_page, 'taveo_load_enqueue_scripts' );

}
function taveo_load_enqueue_scripts(){
	// Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
	add_action( 'admin_enqueue_scripts', 'taveo_style' );
}

function taveo_style(){
	wp_enqueue_style( 'config_screen', plugins_url( '/css/config_screen.css', __FILE__ ) );
}


/*this function adds the Taveo button to every page and post */ 
function taveo_enqueue_admin_js(){
	wp_enqueue_script( 'ajax_request', plugins_url( '/js/ajax_request.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    

    $taveo_api_key=get_option( 'taveo_api_key' );
    
	$data = add_query_arg( array(
	    'apikey' => $taveo_api_key,
	    'destination'     => get_pagepost_url()
	), TAVEO_API_CREATE_URL );


    wp_localize_script( 'ajax_request', 'taveossdata', array(            
        'api_key_url' => $data
    ) );
}



/*this function gets added by the "init" hook, so it is available everywhere*/
function get_pagepost_url(){
	if(isset($_GET['post'])){
	   $cep = $_GET['post'];	   
	   $taveo_url=get_permalink($cep);
	   return urlencode($taveo_url);
	 }
}

// $taveo_url=taveo_get_post_id();
//Enqueues the scripts

/*add a "settings" link to the plugins page */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'admin.php?page=taveo_dashboard' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}



?>
