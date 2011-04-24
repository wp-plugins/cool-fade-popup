<?php

/*
Plugin Name: Cool fade popup
Plugin URI: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
Description: Sometimes its useful to add a pop up to your website to show your ads, special announcement and for offers. Using this plug-in you can creates unblockable, dynamic and fully configurable popups for your blog.
Author: Gopi.R
Version: 2.0
Author URI: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
Donate link: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
*/

global $wpdb, $wp_version;

function PopUpFad()
{
	$PopUpFad_siteurl = get_option('siteurl');
	$PopUpFad_pluginurl = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/";
	$PopUpFad_close = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/close.jpg";
	?>
	<script type="text/javascript" src="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.css" />
	<div id="PopUpFad">
  		<div class="PopUpFadClose"><a href="#" onclick="PopUpFadCloseX()"><img src="<?php echo $PopUpFad_close; ?>" /></a></div>
  		<?php include_once("popup.html"); ?>
	</div>
	<script type="text/javascript">PopUpFadOpen();</script>
	<?php
}


function PopUpFad_activation()
{
	add_option('PopUpFad_Title', "Cool fade popup");
	add_option('PopUpFad_On_Homepage', "YES");
	add_option('PopUpFad_On_Posts', "YES");
	add_option('PopUpFad_On_Pages', "YES");
	add_option('PopUpFad_On_Archives', "NO");
	add_option('PopUpFad_On_Search', "NO");
}

function PopUpFad_deactivate() 
{

}

function PopUpFad_add_to_menu() 
{
	add_options_page('Cool fade popup', 'Cool fade popup', 'manage_options', __FILE__, 'PopUpFad_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'PopUpFad_add_to_menu');
}

function PopUpFad_admin_options() 
{
	?>
	<div class="wrap">
	  <h2><?php echo wp_specialchars( 'Cool fade popup - Display option' ); ?></h2>
	  <?php
	global $wpdb, $wp_version;
	
	$PopUpFad_Title = get_option('PopUpFad_Title');
	$PopUpFad_On_Homepage = get_option('PopUpFad_On_Homepage');
	$PopUpFad_On_Posts = get_option('PopUpFad_On_Posts');
	$PopUpFad_On_Pages = get_option('PopUpFad_On_Pages');
	$PopUpFad_On_Archives = get_option('PopUpFad_On_Archives');
	$PopUpFad_On_Search = get_option('PopUpFad_On_Search');
	
	if ($_POST['PopUpFad_submit']) 
	{
		$PopUpFad_Title = stripslashes(trim($_POST['PopUpFad_Title']));
		$PopUpFad_On_Homepage = stripslashes(trim($_POST['PopUpFad_On_Homepage']));
		$PopUpFad_On_Posts = stripslashes(trim($_POST['PopUpFad_On_Posts']));
		$PopUpFad_On_Pages = stripslashes(trim($_POST['PopUpFad_On_Pages']));
		$PopUpFad_On_Archives = stripslashes(trim($_POST['PopUpFad_On_Archives']));
		$PopUpFad_On_Search = stripslashes(trim($_POST['PopUpFad_On_Search']));
		
		update_option('PopUpFad_Title', $PopUpFad_Title );
		update_option('PopUpFad_On_Homepage', $PopUpFad_On_Homepage );
		update_option('PopUpFad_On_Posts', $PopUpFad_On_Posts );
		update_option('PopUpFad_On_Pages', $PopUpFad_On_Pages );
		update_option('PopUpFad_On_Archives', $PopUpFad_On_Archives );
		update_option('PopUpFad_On_Search', $PopUpFad_On_Search );
	}
	
	echo '<table width="100%" border="0" cellspacing="5" cellpadding="0">';
	echo '<tr>';
	echo '<td align="left">';
	echo '<form name="form_PopUpFad" method="post" action="">';
	echo '<p>Title:<br><input  style="width: 350px;" type="text" value="';
	echo $PopUpFad_Title . '" name="PopUpFad_Title" id="PopUpFad_Title" /> </p>';
	echo '<p>On Homepage:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Homepage . '" name="PopUpFad_On_Homepage" id="PopUpFad_On_Homepage" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Posts:&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Posts . '" name="PopUpFad_On_Posts" id="PopUpFad_On_Posts" /> (YES/NO) </p>';
	echo '<p>On Pages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Pages . '" name="PopUpFad_On_Pages" id="PopUpFad_On_Pages" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Search:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Archives . '" name="PopUpFad_On_Archives" id="PopUpFad_On_Archives" /> (YES/NO) </p>';
	echo '<p>On Archives:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Search . '" name="PopUpFad_On_Search" id="PopUpFad_On_Search" /> (YES/NO) </p>';
	echo '<input type="submit" id="PopUpFad_submit" name="PopUpFad_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />';
	echo '</form>';
	echo '</td>';
	echo '<td align="left">';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	
	?>
  <h2><?php echo wp_specialchars( 'About plugin!' ); ?></h2>
  Plug-in created by <a target="_blank" href='###'>Gopi</a>.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/'>Click here</a> to post suggestion or comments or feedback.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/'>Click here</a> to see plugin live demo.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/'>Click here</a> to see more info & help.<br>
  <a target="_blank" href='http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/'>Click here</a> To download my other plugins & support.<br>
  <br>
</div>
<?php
}

function PopUpFad_plugins_loaded()
{
  	register_sidebar_widget(__('Cool fade popup'), 'PopUpFad_widget');   

	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Cool fade popup', 'PopUpFad_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Cool fade popup', 'widgets'), 'PopUpFad_widget_control', 560, 500);
	} 
}

function PopUpFad_widget_control() 
{
	echo '<p>Cool fade popup.';
  	echo '<br><a href="#">';
	echo 'click here</a></p>';
}

function PopUpFad_widget($args) 
{
	if(is_home() && get_option('PopUpFad_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('PopUpFad_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('PopUpFad_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('PopUpFad_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('PopUpFad_On_Search') == 'YES') {	$display = "show";	}
	
	if($display == "show")
	{
  		PopUpFad();
 	}
}

add_filter('the_content','PopUpFad_filter');

function PopUpFad_filter($content){
	return 	preg_replace_callback('/\[PopUpFad=(.*?)\]/sim','PopUpFad_filter_Callback',$content);
}

function PopUpFad_filter_Callback($matches) 
{
	$popupwindow =  dirname(__FILE__) . '/' . $matches[1];
	$file = file_get_contents($popupwindow);
	$PopUpFad_siteurl = get_option('siteurl');
	$PopUpFad_pluginurl = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/";
	$PopUpFad_close = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/close.jpg";
	
	$PopUpFad_txt = $PopUpFad_txt . '<script type="text/javascript" src="'. $PopUpFad_pluginurl . 'PopUpFad.js"></script>';
	$PopUpFad_txt = $PopUpFad_txt . '<link rel="stylesheet" type="text/css" href="'. $PopUpFad_pluginurl . 'PopUpFad.css" />';
	$PopUpFad_txt = $PopUpFad_txt . '<div id="PopUpFad">';
  		$PopUpFad_txt = $PopUpFad_txt . '<div class="PopUpFadClose"><a href="#" onclick="PopUpFadCloseX()"><img src="'. $PopUpFad_close . '" /></a></div>';
  		$PopUpFad_txt = $PopUpFad_txt . $file;
	$PopUpFad_txt = $PopUpFad_txt . '</div>';
	$PopUpFad_txt = $PopUpFad_txt . '<script type="text/javascript">PopUpFadOpen();</script>';
	return $PopUpFad_txt;
}

register_activation_hook(__FILE__, 'PopUpFad_activation');
add_action('admin_menu', 'PopUpFad_add_to_menu');
add_action("plugins_loaded", "PopUpFad_plugins_loaded");
register_deactivation_hook( __FILE__, 'PopUpFad_deactivate' );


?>