<?php
   /*
   Plugin Name: Simplest cookie notice
   description: Plugin for displaying cookie notice
   Version: 1.1.2
   Author: Ruby
   Prefix: rcnp_
   */
?>
<?php

add_action('admin_enqueue_scripts', 'rcnp_codemirror_enqueue_scripts');
 
function rcnp_codemirror_enqueue_scripts($hook) {
  $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
  wp_localize_script('jquery', 'cm_settings', $cm_settings);
 
  wp_enqueue_script('wp-theme-plugin-editor');
  wp_enqueue_style('wp-codemirror');
}


function rcnp_displayNotice(){
	if(has_action('wpml_current_language')) $currentLang = apply_filters( 'wpml_current_language', NULL );
	else $currentLang = 'en';
	
?>
	<style>
	#rcnp_allow-cookies {
		width:100%;
		background-color: <?php echo get_option('choosen_background_color_RsCN_value'.'_language_'.$currentLang, '#ffffff'); ?>;
		position:fixed;
		bottom:0;
		z-index:9999;
		display: flex;
		justify-content: center;
		padding: 15px 10px;
		border: 3px solid <?php echo get_option('choosen_main_border_color_RsCN_value'.'_language_'.$currentLang, '#000000'); ?>;
		color: <?php echo get_option('choosen_font_color_RsCN_value'.'_language_'.$currentLang, '#000000'); ?>;
		align-items: center;
		box-sizing: border-box;
	}
	#rcnp_div-wtih-text {
		max-width: 650px;
		margin-right: 50px;
		font-size: 14px;
	}
	#rcnp_allow-cookies button {
		font-size: 15px;
		cursor: pointer;
		padding: 10px 25px;
		background-color: <?php echo get_option('choosen_button_color_RsCN_value'.'_language_'.$currentLang, '#ffffff'); ?>;
		border: 3px solid <?php echo get_option('choosen_button_border_color_RsCN_value'.'_language_'.$currentLang, '#000000'); ?>;

	}
	@media only screen and (max-width: 567px) {
		#rcnp_div-wtih-text {
			font-size: 11px;
		}
		#rcnp_allow-cookies button {
			padding: 5px 13px;
		}
	 }
	<?php echo esc_html(get_option('additional_RsCN_css'."_language_".$currentLang)); ?>
	</style>
	<script>
	function doOnce() {
		if (document.cookie.replace(/(?:(?:^|.*;\s*)<?php echo esc_textarea(get_option('cookie_name_RsCN_value'.'_language_'.$currentLang, 'cookieToEndAllCookies')); ?>\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
			document.cookie = "<?php echo esc_textarea(get_option('cookie_name_RsCN_value'.'_language_'.$currentLang, 'cookieToEndAllCookies')); ?>=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
			document.getElementById("rcnp_allow-cookies").style.display='none';
		}
	}
	function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
	}
	function eraseCookie(name) {
		document.cookie = name+'=; Max-Age=-99999999;';
	}
	</script>
	<div id="rcnp_allow-cookies">
		<div id="rcnp_div-wtih-text">
			<?php echo get_option('text_for_RsCN_value'.'_language_'.$currentLang, 'Will you accept all my cookies?'); ?>
		</div>
		<button onclick="doOnce();"><?php echo esc_textarea(get_option('text_for_button_RsCN_value'.'_language_'.$currentLang, 'Accept')); ?></button>
	</div>
	<script>if(getCookie("<?php echo esc_textarea(get_option('cookie_name_RsCN_value'.'_language_'.$currentLang, 'cookieToEndAllCookies')); ?>") == "true")  document.getElementById("rcnp_allow-cookies").style.display='none';</script>
	<!--#cookie notice end-->
<?php
}

add_action('wp_footer', 'rcnp_displayNotice');



add_action( 'admin_enqueue_scripts', 'rcnp_mw_enqueue_color_picker' );
function rcnp_mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('scripts-with-stuff.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}



function rcnp_text_for_RsCN($settingLan){	
	?>
	
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Enter text for notice. You can use any of html tags here.",'rcnp_plugin_strings') ?></p>
		<textarea id="text-for-notice" rows="5" name="text_for_RsCN_value_language_<?php echo $settingLan;?>" class="widefat textarea"><?php echo get_option('text_for_RsCN_value'.'_language_'.$settingLan, 'Will you accept all my cookies?'); ?></textarea>   
	</fieldset>
	<?php		
}
function rcnp_text_for_button_RsCN($settingLan){	
	?>
	
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Enter text for button.",'rcnp_plugin_strings') ?></p>
		<input id="text-for-button" name="text_for_button_RsCN_value_language_<?php echo $settingLan;?>" class="widefat textarea" value="<?php echo get_option('text_for_button_RsCN_value'.'_language_'.$settingLan, 'Accept'); ?>"></input>   
	</fieldset>
	<?php		
}
function rcnp_cookie_namee_RsCN($settingLan){	
	?>
	
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Name cookie that will disable notice, note that changing it would reset notice display. For manual deleting of cookie, you can use 'eraseCookie' JS function.",'rcnp_plugin_strings') ?></p>
		<input id="cookie-name" name="cookie_name_RsCN_value_language_<?php echo $settingLan;?>" class="widefat textarea" value="<?php echo get_option('cookie_name_RsCN_value'.'_language_'.$settingLan, 'cookieToEndAllCookies'); ?>"></input>
	</fieldset>
	<?php		
}
function rcnp_css_for_RsCN($settingLan){	
	?>
	
	<fieldset style="width: 800px;">
		<p class="description"><b><?php _e("Use with care.",'rcnp_plugin_strings') ?></b> <?php _e("Enter any additional CSS code. Beware that this would be in 'style' tag, so wrong usage could posibly brake the page.",'rcnp_plugin_strings') ?></p>
		<textarea id="css-for-notice" rows="5" name="additional_RsCN_css_language_<?php echo $settingLan;?>" class="widefat textarea code_editor_here_please"><?php echo get_option('additional_RsCN_css'.'_language_'.$settingLan); ?></textarea>   
	</fieldset>
	<?php	
	do_action('run_code_editor');
}
function rcnp_pick_main_border_color_RsCN($settingLan){	
	?>
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Pick color for main border of the box.",'rcnp_plugin_strings') ?></p>
	</fieldset>
	<input type="text" name="choosen_main_border_color_RsCN_value_language_<?php echo $settingLan;?>" value="<?php echo get_option('choosen_main_border_color_RsCN_value'.'_language_'.$settingLan, '#000000'); ?>" class="my-color-field"/>
	<?php		
}
function rcnp_pick_background_color_RsCN($settingLan){	
	?>
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Pick color for background of the box.",'rcnp_plugin_strings') ?></p>
	</fieldset>
	<input type="text" name="choosen_background_color_RsCN_value_language_<?php echo $settingLan;?>" value="<?php echo get_option('choosen_background_color_RsCN_value'.'_language_'.$settingLan, '#ffffff'); ?>" class="my-color-field"/>
	<?php		
}
function rcnp_pick_font_color_RsCN($settingLan){	
	?>
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Pick color for font.",'rcnp_plugin_strings') ?></p>
	</fieldset>
	<input type="text" name="choosen_font_color_RsCN_value_language_<?php echo $settingLan;?>" value="<?php echo get_option('choosen_font_color_RsCN_value'.'_language_'.$settingLan, '#000000'); ?>" class="my-color-field"/>
	<?php		
}
function rcnp_pick_button_color_RsCN($settingLan){	
	?>
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Pick color for button's background color.",'rcnp_plugin_strings') ?></p>
	</fieldset>
	<input type="text" name="choosen_button_color_RsCN_value_language_<?php echo $settingLan;?>" value="<?php echo get_option('choosen_button_color_RsCN_value'.'_language_'.$settingLan, '#ffffff'); ?>" class="my-color-field"/>
	<?php			
}
function rcnp_pick_button_border_color_RsCN($settingLan){	
	?>
	<fieldset style="width: 800px;">
		<p class="description"><?php _e("Pick color for button's border color.",'rcnp_plugin_strings') ?></p>
	</fieldset>
	<input type="text" name="choosen_button_border_color_RsCN_value_language_<?php echo $settingLan;?>" value="<?php echo get_option('choosen_button_border_color_RsCN_value'.'_language_'.$settingLan, '#000000'); ?>" class="my-color-field"/>
	<?php			
}

function rcnp_display_RsCN_settings_fields(){
	if(has_action('wpml_current_language')) $currentLang = apply_filters( 'wpml_current_language', NULL );
	else $currentLang = 'en';
	
	add_settings_section("settings_for_rscn", "All Settings", null, "RsCN-options");
	add_settings_field("text_for_RsCN_value"."_language_".$currentLang, "", "rcnp_text_for_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("text_for_button_RsCN_value"."_language_".$currentLang, "", "rcnp_text_for_button_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("cookie_name_RsCN_value"."_language_".$currentLang, "", "rcnp_cookie_namee_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	
	add_settings_field("additional_RsCN_css"."_language_".$currentLang, "", "rcnp_css_for_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	
	add_settings_field("choosen_main_border_color_RsCN_value"."_language_".$currentLang, "", "rcnp_pick_main_border_color_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("choosen_background_color_RsCN_value"."_language_".$currentLang, "", "rcnp_pick_background_color_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("choosen_font_color_RsCN_value"."_language_".$currentLang, "", "rcnp_pick_font_color_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("choosen_button_color_RsCN_value"."_language_".$currentLang, "", "rcnp_pick_button_color_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	add_settings_field("choosen_button_border_color_RsCN_value"."_language_".$currentLang, "", "rcnp_pick_button_border_color_RsCN", "RsCN-options", "settings_for_rscn", $currentLang);
	
	
	
	$colors = array('sanitize_callback' => 'sanitize_text_field','default' => NULL );
	register_setting("settings_for_rscn", "text_for_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'wp_kses_post','default' => 'Will you accept all my cookies?' ));
	register_setting("settings_for_rscn", "text_for_button_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_text_field','default' => 'Accept' ));
	register_setting("settings_for_rscn", "cookie_name_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_text_field','default' => 'cookieToEndAllCookies' ));
	register_setting("settings_for_rscn", "additional_RsCN_css"."_language_".$currentLang);
	register_setting("settings_for_rscn", "choosen_main_border_color_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_hex_color','default' => '#000000' ));
	register_setting("settings_for_rscn", "choosen_background_color_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_hex_color','default' => '#ffffff' ));
	register_setting("settings_for_rscn", "choosen_font_color_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_hex_color','default' => '#000000' ));
	register_setting("settings_for_rscn", "choosen_button_color_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_hex_color','default' => '#ffffff' ));
	register_setting("settings_for_rscn", "choosen_button_border_color_RsCN_value"."_language_".$currentLang, array('sanitize_callback' => 'sanitize_hex_color','default' => '#000000' ));
	
}
add_action("admin_init", "rcnp_display_RsCN_settings_fields");

	
	


function rcnp_RsCN_settings_page(){
?>
	<div class="wrap">
	<h1><?php _e("Ruby's cookie notice options",'rcnp_plugin_strings') ?></h1>
	<form method="post" action="options.php">
		<?php
			settings_fields("settings_for_rscn");
			do_settings_sections("RsCN-options");      
			submit_button();
		?>          
	</form>
	</div>
<?php
}

function rcnp_add_RsCN_settings_item()
{
	add_submenu_page( "options-general.php", __('Simple cookie notice setting page','rcnp_plugin_strings'), __('Cookie notice','rcnp_plugin_strings'), "manage_options", "rscn-settings", "rcnp_RsCN_settings_page");
}
add_action("admin_menu", "rcnp_add_RsCN_settings_item");

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=rscn-settings' ) .
		'">' . __('Settings', 'rcnp_plugin_strings') . '</a>';
	return $links;
}

?>
