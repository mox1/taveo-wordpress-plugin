<?php 
//Security Enhancement
defined( 'ABSPATH' ) or die( 'Go Away.' );



add_action( 'admin_post_taveo_api_key_option', 'process_taveo_api_key_option' );

function process_taveo_api_key_option(){

	if ( !current_user_can( 'manage_options' ) )
   {
      wp_die( 'You are not allowed to be on this page.' );
   }
   check_admin_referer( 'taveo_verify','taveo_dash_nonce' );
   

   if ( isset( $_POST['taveo_api_key'] ) )
   {
      $taveo_key = sanitize_text_field( $_POST['taveo_api_key'] );

   }
   update_option( 'taveo_api_key',$taveo_key );
 
   wp_redirect(  admin_url( 'admin.php?page=taveo_dashboard&settings-updated=1' ) );
   //wp_redirect( admin_url('admin.php?page='.$_GET["page"]. '&settings-updated=1') );
   exit;

}



//The markup for the plugin settings / dashboard page
function taveo_build_config_screen(){ ?>
    <div class="wrap clear">
    <h2>Taveo: Settings</h2>
    <?php
	  if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == '1' )
	  {
	?>
	   <div id='message' class='updated fade'><p><strong>Settings Successfully Saved</strong></p></div>
	<?php
	  }
?>	<div class="container left">
	<p> Enter your Taveo API key below. Your Taveo API key can be found on your "Account" page in the Taveo Admin portal.<br> 
		<a href="https://admin.taveo.net/login?nxt=/account" target="_blank">Click here to view your Taveo Account</a><br>
		</p>
    <form action="admin-post.php" method="post" >
    	<input type="hidden" name="action" value="taveo_api_key_option" />
    	<?php wp_nonce_field('taveo_verify','taveo_dash_nonce'); ?>
    	<?php
        //get the older values, wont work the first time
        $options = get_option( 'taveo_api_key' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">API Key :</th>
                <td>
                    <fieldset>
                        <label>
                            <input size="30" placeholder="Please enter your API Key" class="taveotextinput" name="taveo_api_key" type="text" id="taveo_api_key" value="<?php echo (isset($options) && $options != '') ? $options : ''; ?>"/>
                            
                            
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>

        
        <input name="submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />      </p> 
    	</form>
    	<table class="taveo_table">
        <?php
    	if ( !empty( $options )) {
    		//make request to Taveo API server and get response
			$response = wp_remote_get( add_query_arg( array(
	    								'apikey' => $options), TAVEO_API_OVERVIEW_URL ), array('sslverify' => TAVEO_SSL_VERIFY) );
			$rcode = wp_remote_retrieve_response_code( $response );
			$overview = json_decode( wp_remote_retrieve_body( $response ), true );
			if (!(200 ==  $rcode) ) {
			    //Error, print what happened
			    ?>
			    <th scope="row">Received Error from Taveo Server: <?php echo $overview['msg']; ?></th>
				<?php
			}
			
			if($overview['status']=='ok') {
				?>
	            <tr>
	                <th scope="row">Account :</th>
	                <td>
	                    <?php echo $overview['account']; ?>
	                </td>
	            </tr>
	            <tr>
	                <th scope="row">Clicks today:</th>
	                <td>
	                    <?php echo $overview['clicks_today']; ?>
	                </td>
	            </tr>
	            <tr>
	                <th scope="row">Clicks on this month :</th>
	                <td>
	                    <?php echo $overview['clicks_month']; ?>
	                </td>
	            </tr>
        		<?php 
			}
			else{
    			?>
	            <tr>
	            	<th scope="row">There was a problem! Please check your API Key or wait a few minutes.</th>
	                
	            </tr>
        		<?php 
        	}   
        } 
        
    ?>
    </table><br><br>
    <h4>Don't have a Taveo account? <a href="https://admin.taveo.net/register">Create one for FREE.</h4>
    </div>
    <div class="wpseo_content_cell right" id="sidebar-container">
			<div id="sidebar">
				<?php
							

				$service_banners = array(
					array(
						'url' => 'https://taveo.com/link1',
						'img' => 'banner-1.jpg',
						'alt' => 'Website Review banner',
					),
				);

				$plugin_banners = array(
					array(
						'url' => 'https://taveo.com/link1',
						'img' => 'banner-2.jpg',
						'alt' => 'Banner WordPress SEO Premium',
					),
					array(
						'url' => 'https://taveo.com/link1',
						'img' => 'banner-3.jpg',
						'alt' => 'Banner WordPress SEO Video SEO extension',
					),
					array(
						'url' => 'https://taveo.com/link1',
						'img' => 'banner-4.jpg',
						'alt' => 'Banner WooCommerce SEO plugin',
					),
					
					

				);

								

				shuffle( $service_banners );
				shuffle( $plugin_banners );
				$service_banner = $service_banners[0];

				echo '<a target="_blank" href="' . esc_url( $service_banner['url'] ) . '"><img width="261" height="190" src="' . plugins_url( 'images/' . $service_banner['img'], __FILE__ ) . '" alt="' . esc_attr( $service_banner['alt'] ) . '"/></a><br/><br/>';

				$i = 0;
				foreach ( $plugin_banners as $banner ) {
					if ( $i == 2 ) {
						break;
					}
					echo '<a target="_blank" href="' . esc_url( $banner['url'] ) . '"><img width="261" src="' . plugins_url( 'images/' . $banner['img'], __FILE__ ) . '" alt="' . esc_attr( $banner['alt'] ) . '"/></a><br/><br/>';
					$i ++;
				}
				?>
				
			</div>
		</div>

</div>
<?php }
?>
