<?php  
//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );

add_action( 'post_submitbox_misc_actions', 'publish_in_frontpage' );
function publish_in_frontpage($post) {
?>
	<div class="misc-pub-section misc-pub-section-last" id="publish_in_frontpage">
         <span id="timestamp">
         <a class="add_to_taveo_button button" href="#" >Old Taveo Btn</a>
         <span class="spinner taveo_load"></span></span><br><br>
         <a href="#" class="button" id="taveo_post_btn">Track with Taveo</a><br>
         <div id="tlinkmsg" style="display: none;">There are currently <a class="scroll" href="#taveo_meta_links"><span id="curtlinks"></span> Taveo links</a> for this page.</div>
    </div>
    <div class="misc-pub-section misc-pub-section-last" id="returned_url"></div>    
<?php    
}

function taveo_metabox_callback ( $post, $metabox ) {
?>
	<div id="tlinkdata"></div>
<?php	 
}

?>