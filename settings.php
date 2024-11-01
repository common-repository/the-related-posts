<?php
	
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	
	function alobaidi_related_posts_settings() {
		add_plugins_page( 'Related Posts Settings', 'Related Posts', 'manage_options', 'alobaidi_related_posts_settings', 'alobaidi_related_posts_settings_page');
	}
	add_action( 'admin_menu', 'alobaidi_related_posts_settings' );
	
	function alobaidi_related_posts_register_setting() {
		register_setting( 'alobaidi_related_posts_settings_fields', 'obi_related_posts_limit' );
		register_setting( 'alobaidi_related_posts_settings_fields', 'obi_related_posts_title' );
		register_setting( 'alobaidi_related_posts_settings_fields', 'obi_related_posts_list' );
		register_setting( 'alobaidi_related_posts_settings_fields', 'obi_related_posts_heading' );
	}
	add_action( 'admin_init', 'alobaidi_related_posts_register_setting' );
		
	function alobaidi_related_posts_settings_page(){ // page function
		?>
			<div class="wrap">
				<h2>Related Posts Settings</h2>

				<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
					<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
						<p><strong>Settings saved.</strong></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
					</div>
				<?php } ?>

            	<form method="post" action="options.php">
                	<?php settings_fields( 'alobaidi_related_posts_settings_fields' ); ?>

                	<table class="form-table">
                		<tbody>
                            
                    		<tr>
                        		<th scope="row"><label for="obi_related_posts_title">Title</label></th>
                            	<td>
                                    <input class="regular-text" name="obi_related_posts_title" type="text" id="obi_related_posts_title" value="<?php echo esc_attr( get_option('obi_related_posts_title') ); ?>">
                                    <p class="description">Enter your title, default title is "Related Posts".</p>
								</td>
                        	</tr>

                    		<tr>
                        		<th scope="row"><label for="obi_related_posts_heading">Title Heading</label></th>
                            	<td>
                                    <input class="small-text" name="obi_related_posts_heading" type="text" id="obi_related_posts_heading" value="<?php echo esc_attr( get_option('obi_related_posts_heading') ); ?>">
                                    <p class="description">Enter title heading, for example "h2", default heading is "h4" (<?php echo esc_html('<h4>'); ?>).</p>
								</td>
                        	</tr>

                        	<tr>
                        		<th scope="row"><label for="obi_related_posts_list">List Type</label></th>
                            	<td>
                                    <input class="small-text" name="obi_related_posts_list" type="text" id="obi_related_posts_list" value="<?php echo esc_attr( get_option('obi_related_posts_list') ); ?>">
                                    <p class="description">Enter list type, for example "ol", default list type is "ul" (<?php echo esc_html('<ul>'); ?>).</p>
								</td>
                        	</tr>

                        	<tr>
                        		<th scope="row"><label for="obi_related_posts_limit">Number Of Posts</label></th>
                            	<td>
                                    <input class="small-text" name="obi_related_posts_limit" type="text" id="obi_related_posts_limit" value="<?php echo esc_attr( get_option('obi_related_posts_limit') ); ?>">
                                    <p class="description">Enter number of related posts, default number is "5".</p>
								</td>
                        	</tr>

                    	</tbody>
                    </table>

                    <p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
                </form>

            	<div class="tool-box">
					<h3 class="title">Recommended Links</h3>
					<p>Get collection of 87 WordPress themes for $69 only, a lot of features and free support! <a href="http://j.mp/ET_WPTime_ref_pl" target="_blank">Get it now</a>.</p>
					<p>See also:</p>
						<ul>
							<li><a href="http://j.mp/CM_WPTime" target="_blank">Premium WordPress themes on CreativeMarket.</a></li>
							<li><a href="http://j.mp/TF_WPTime" target="_blank">Premium WordPress themes on Themeforest.</a></li>
							<li><a href="http://j.mp/CC_WPTime" target="_blank">Premium WordPress plugins on Codecanyon.</a></li>
						</ul>
					<p><a href="http://j.mp/ET_WPTime_ref_pl" target="_blank"><img style="max-width:100%;" src="<?php echo plugins_url( '/banner/570x100.jpg', __FILE__ ); ?>"></a></p>
				</div>

            </div>
        <?php
	} // settings page function

?>