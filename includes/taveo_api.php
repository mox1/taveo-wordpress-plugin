<?php  
//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );

$response = wp_remote_get( add_query_arg( array(
    'apikey' => TAVEO_API_KEY,
    'url'     => absint( $count )
), TAVEO_API_CREATE_URL ),array('sslverify' => TAVEO_SSL_VERIFY) );

// Is the API up?
if ( ! 200 == wp_remote_retrieve_response_code( $response ) ) {
    return false;
}
?>