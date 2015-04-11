<?php  
//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );

add_action( 'post_submitbox_misc_actions', 'publish_in_frontpage' );
function publish_in_frontpage($post)
{
    
    echo '<div class="misc-pub-section misc-pub-section-last" id="publish_in_frontpage">
         <span id="timestamp">'
         . '<a class="add_to_taveo_button button" href="#" >Track With Taveo</a>
         <span class="spinner taveo_load"></span>'
    .'</span></div><div class="misc-pub-section misc-pub-section-last" id="returned_url"></div>';
    
}



?>