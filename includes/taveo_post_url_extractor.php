<?php  
//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );

function taveo_get_post_id()
{
	if(isset($_GET['post'])){
	$cep = $_GET['post'];
	//permalink
	$taveo_url=get_permalink( $cep );
	return $taveo_url;
	}
}


?>