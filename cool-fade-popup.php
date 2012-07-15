<?php

/*
Plugin Name: Cool fade popup
Plugin URI: http://www.gopipulse.com/work/2011/01/08/cool-fade-popup/
Description: Sometimes its useful to add a pop up to your website to show your ads, special announcement and for offers. Using this plug-in you can creates unblockable, dynamic and fully configurable popups for your blog.
Author: Gopi.R
Version: 5.0
Author URI: http://www.gopipulse.com/work/2011/01/08/cool-fade-popup/
Donate link: http://www.gopipulse.com/work/2011/01/08/cool-fade-popup/
*/

global $wpdb, $wp_version;
define("WP_PopUpFad_TABLE", $wpdb->prefix . "PopUpFadpopup");

if (!session_id()) { session_start(); }

function PopUpFad()
{
	
	global $wpdb;
	$PopUpFad_Group = get_option('PopUpFad_Group');
	
	$sSql = "select PopUpFad_text from ".WP_PopUpFad_TABLE." where PopUpFad_status='YES'";
	
	if(@$PopUpFad_Group <> "")
	{
		 $sSql = $sSql . " and PopUpFad_group='".$PopUpFad_Group."'";
	}
	
	if(@$PopUpFad_random <> "")
	{
		$sSql = $sSql . " Order by rand()";
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$PopUpData = stripslashes($data->PopUpFad_text);
		}
	}
	else
	{
		$PopUpData = "No content available in the db with the group name " . $PopUpFad_group . ". Please check the plugin page or in the admin to find more info.";
	}
	
	
	$PopUpFad_siteurl = get_option('siteurl');
	$PopUpFad_pluginurl = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/";
	$PopUpFad_close = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/close.jpg";
	?>
	<script type="text/javascript" src="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.css" />
	<div id="PopUpFad">
  		<div class="PopUpFadClose"><a href="#" onclick="PopUpFadCloseX()"><img src="<?php echo $PopUpFad_close; ?>" /></a></div>
        <div>
  		<?php echo $PopUpData; ?>
        </div>
	</div>
	<script type="text/javascript">PopUpFadOpen();</script>
	<?php
}


function PopUpFad_activation()
{
	
	global $wpdb;
	
	$c1 = '<div>';
	$c1 = $c1.'<h2 align="left">Cool fading popup demo</h2><br />';
	$c1 = $c1.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="http://www.gopipulse.com/work/wp-content/uploads/2011/01/gopipulse.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	$c1 = $c1.'</p>';
	$c1 = $c1.'</div>';
	
	$c2 = '<div>';
	$c2 = $c2.'<h2 align="left">Cool fading popup plugin</h2><br />';
	$c2 = $c2.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="http://www.gopipulse.com/work/wp-content/uploads/2011/01/gopipulse.com-popup.png" alt="Gopi" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	$c2 = $c2.'</p>';
	$c2 = $c2.'</div>';
	
	$c3 = '<div>';
	$c3 = $c3.'<h2 align="left">Cool fading popup plugin</h2>';
	$c3 = $c3.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="http://www.gopipulse.com/work/wp-content/uploads/2011/01/gopipulse.com-popup.png" alt="Gopi" />Dit is de demo voor koele fade popup plugin. het gebruik van deze plugin kunt u deze toevoegen coole pop-up venster in uw WordPress website. het gebruik van deze blokkeerbaar popup-venster kunt u uw advertenties, speciale informatie, aanbiedingen en aankondigingen. Sluit deze popup en lees het artikel kunt u eenvoudig configureren van deze plugin in je WordPress website. zijn zeer eenvoudig. Aarzel niet om bericht dat u opmerkingen en feedback.</p>';
	$c3 = $c3.'</p>';
	$c3 = $c3.'</div>';
	
	$c4 = '<div>';
	$c4 = $c4.'<h2 align="left">Cool fading popup plugin</h2>';
	$c4 = $c4.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="Gopi" src="http://www.gopipulse.com/work/wp-content/uploads/2011/01/gopipulse.com-popup.png" alt="Gopi" />Il sagit de la démo pour popup cool fade plugin. lutilisation de ce plugin, vous pouvez ajouter cette fenêtre popup cool dans votre site wordpress. utilisation de cette fenêtre popup imblocable vous pouvez ajouter vos annonces, informations spéciales, des offres et des annonces. Fermer cette popup et lire larticle, vous pouvez facilement configurer ce plugin dans votre site wordpress. son très simple. sil vous plaît nhésitez pas à poster vos commentaires et la rétroaction.</p>';
	$c4 = $c4.'</p>';
	$c4 = $c4.'</div>';
	
	
	if($wpdb->get_var("show tables like '". WP_PopUpFad_TABLE . "'") != WP_PopUpFad_TABLE) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_PopUpFad_TABLE . "` (
			  `PopUpFad_id` int(11) NOT NULL auto_increment,
			  `PopUpFad_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `PopUpFad_status` char(3) NOT NULL default 'No',
			  `PopUpFad_group` VARCHAR( 100 ) NOT NULL,
			  `PopUpFad_extra1` VARCHAR( 100 ) NOT NULL,
			  `PopUpFad_extra2` VARCHAR( 100 ) NOT NULL,
			  `PopUpFad_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`PopUpFad_id`) )
			");
		$iIns = "INSERT INTO `". WP_PopUpFad_TABLE . "` (`PopUpFad_text`, `PopUpFad_status`, `PopUpFad_group`, `PopUpFad_date`)"; 
		$sSql = $iIns . " VALUES ('$c1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$c2', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$c3', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$c4', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('PopUpFad_Title', "Cool fade popup");
	add_option('PopUpFad_On_Homepage', "YES");
	add_option('PopUpFad_On_Posts', "YES");
	add_option('PopUpFad_On_Pages', "YES");
	add_option('PopUpFad_On_Archives', "NO");
	add_option('PopUpFad_On_Search', "NO");
	add_option('PopUpFad_Group', "widget");
	add_option('PopUpFad_Random', "YES");
	add_option('PopUpFad_Session', "NO");
}

function PopUpFad_deactivate() 
{

}

function PopUpFad_add_to_menu() 
{
	add_options_page('Cool fade popup', 'Cool fade popup', 'manage_options', __FILE__, 'PopUpFad_admin_options' );
	add_options_page('Cool fade popup', '', 'manage_options', "cool-fade-popup/content-management.php",'' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'PopUpFad_add_to_menu');
}

function PopUpFad_admin_options() 
{
	?>
	<div class="wrap">
	  <h2>Cool fade popup - Display option & Widget setup</h2>
	  <?php
	global $wpdb, $wp_version;
	
	$PopUpFad_Title = get_option('PopUpFad_Title');
	$PopUpFad_On_Homepage = get_option('PopUpFad_On_Homepage');
	$PopUpFad_On_Posts = get_option('PopUpFad_On_Posts');
	$PopUpFad_On_Pages = get_option('PopUpFad_On_Pages');
	$PopUpFad_On_Archives = get_option('PopUpFad_On_Archives');
	$PopUpFad_On_Search = get_option('PopUpFad_On_Search');
	$PopUpFad_Group = get_option('PopUpFad_Group');
	$PopUpFad_Session = get_option('PopUpFad_Session');
	$PopUpFad_Random = get_option('PopUpFad_Random');
	
	if (@$_POST['PopUpFad_submit']) 
	{
		$PopUpFad_Title = stripslashes(trim($_POST['PopUpFad_Title']));
		$PopUpFad_On_Homepage = stripslashes(trim($_POST['PopUpFad_On_Homepage']));
		$PopUpFad_On_Posts = stripslashes(trim($_POST['PopUpFad_On_Posts']));
		$PopUpFad_On_Pages = stripslashes(trim($_POST['PopUpFad_On_Pages']));
		$PopUpFad_On_Archives = stripslashes(trim($_POST['PopUpFad_On_Archives']));
		$PopUpFad_On_Search = stripslashes(trim($_POST['PopUpFad_On_Search']));
		$PopUpFad_Group = stripslashes(trim($_POST['PopUpFad_Group']));
		$PopUpFad_Session = stripslashes(trim($_POST['PopUpFad_Session']));
		$PopUpFad_Random = stripslashes(trim($_POST['PopUpFad_Random']));
		
		update_option('PopUpFad_Title', $PopUpFad_Title );
		update_option('PopUpFad_On_Homepage', $PopUpFad_On_Homepage );
		update_option('PopUpFad_On_Posts', $PopUpFad_On_Posts );
		update_option('PopUpFad_On_Pages', $PopUpFad_On_Pages );
		update_option('PopUpFad_On_Archives', $PopUpFad_On_Archives );
		update_option('PopUpFad_On_Search', $PopUpFad_On_Search );
		update_option('PopUpFad_Group', $PopUpFad_Group );
		update_option('PopUpFad_Session', $PopUpFad_Session );
		update_option('PopUpFad_Random', $PopUpFad_Random );
	}
	
	echo '<table width="100%" border="0" cellspacing="5" cellpadding="0">';
	echo '<tr>';
	echo '<td align="left">';
	echo '<form name="form_PopUpFad" method="post" action="">';
	echo '<p>Title:<br><input  style="width: 357px;" type="text" value="';
	echo $PopUpFad_Title . '" name="PopUpFad_Title" id="PopUpFad_Title" /> </p>';
	echo '<p>On Homepage:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Homepage . '" name="PopUpFad_On_Homepage" id="PopUpFad_On_Homepage" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Posts:&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Posts . '" name="PopUpFad_On_Posts" id="PopUpFad_On_Posts" /> (YES/NO) </p>';
	echo '<p>On Pages:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Pages . '" name="PopUpFad_On_Pages" id="PopUpFad_On_Pages" /> (YES/NO) ';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;On Search:&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Archives . '" name="PopUpFad_On_Archives" id="PopUpFad_On_Archives" /> (YES/NO) </p>';
	echo '<p>On Archives:&nbsp;&nbsp;&nbsp;&nbsp;<input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_On_Search . '" name="PopUpFad_On_Search" id="PopUpFad_On_Search" /> (YES/NO) </p>';
	
	echo '<p>Group name :&nbsp;&nbsp;&nbsp;<input  style="width: 100px;" type="text" value="';
	echo $PopUpFad_Group . '" name="PopUpFad_Group" id="PopUpFad_Group" /> (This is for only widget) </p>';
	echo '<p>Enable Popup Session: <input  style="width: 54px;" type="text" value="';
	echo $PopUpFad_Session . '" name="PopUpFad_Session" id="PopUpFad_Session" /> (YES/NO) (This is to display popup once per session)</p>';
	echo '<p>Enable Random Option: <input  style="width: 50px;" type="text" value="';
	echo $PopUpFad_Random . '" name="PopUpFad_Random" id="PopUpFad_Random" /> (YES/NO) (This is to pick content randomly)</p>';
	
	echo '<input type="submit" id="PopUpFad_submit" name="PopUpFad_submit" lang="publish" class="button-primary" value="Update Setting" value="1" />';
	echo '</form>';
	echo '</td>';
	echo '<td align="left">';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	
	?>
    <div style="float:right;">
      <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/content-management.php'" value="Go to - Content Management" type="button" />
      <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/cool-fade-popup.php'" value="Go to - Popup Setting" type="button" />
    </div>
    <?php include_once("help.php"); ?>
</div>
<?php
}

function PopUpFad_plugins_loaded()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('cool-fade-popup', 'Cool fade popup', 'PopUpFad_widget');
	}
	
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('cool-fade-popup', array('Cool fade popup', 'widgets'), 'PopUpFad_widget_control', 560, 500);
	} 
}

function PopUpFad_widget_control() 
{
	echo '<p>Cool fade popup.';
  	echo '<br><a href="http://www.gopipulse.com/work/2011/01/08/cool-fade-popup/">';
	echo 'click here</a></p>';
}

function PopUpFad_widget($args) 
{
	if(is_home() && get_option('PopUpFad_On_Homepage') == 'YES') {	$display = "show";	}
	if(is_single() && get_option('PopUpFad_On_Posts') == 'YES') {	$display = "show";	}
	if(is_page() && get_option('PopUpFad_On_Pages') == 'YES') {	$display = "show";	}
	if(is_archive() && get_option('PopUpFad_On_Archives') == 'YES') {	$display = "show";	}
	if(is_search() && get_option('PopUpFad_On_Search') == 'YES') {	$display = "show";	}
	
	$PopUpFad_Session = get_option('PopUpFad_Session');
	
	if($PopUpFad_Session == "NO")
	{
		if($display == "show")
		{
			PopUpFad();
		}
	}
	else
	{
		if ( $_SESSION['PopUpFad_Session'] <> "YES" )
		{
			$_SESSION['PopUpFad_Session'] = "YES"; 
			if($display == "show")
			{
				PopUpFad();
			}
		}
	}
	
}

add_filter('the_content','PopUpFad_filter');

function PopUpFad_filter($content){
	return 	preg_replace_callback('/\[PopUpFad=(.*?)\]/sim','PopUpFad_filter_Callback',$content);
}

function PopUpFad_filter_Callback($matches) 
{
	
	global $wpdb;
	//PopUpFad=GROUP=widget:RANDOM=YES:SESSION=NO
	$PopUpFad_txt = "";
	$scode = $matches[1];
	
	$PopUpFad_group_main = "";
	$PopUpFad_random_main = "";
	$PopUpFad_session_main = "";
	$PopUpFad_group_cap = "";
	$PopUpFad_random_cap = "";
	$PopUpFad_session_cap = "";
	$PopUpFad_group = "";
	$PopUpFad_group_main = "";
	
	list($PopUpFad_group_main, $PopUpFad_random_main, $PopUpFad_session_main) = split("[:.-]", $scode);
	list($PopUpFad_group_cap, $PopUpFad_group) = split('[=.-]', $PopUpFad_group_main);
	list($PopUpFad_random_cap, $PopUpFad_random) = split('[=.-]', $PopUpFad_random_main);
	list($PopUpFad_session_cap, $PopUpFad_session) = split('[=.-]', $PopUpFad_session_main);
	
	$sSql = "select PopUpFad_text from ".WP_PopUpFad_TABLE." where PopUpFad_status='YES'";
	
	
	if(@$PopUpFad_group <> "")
	{
		 $sSql = $sSql . " and PopUpFad_group='".$PopUpFad_group."'";
	}
	
	if(@$PopUpFad_random <> "")
	{
		$sSql = $sSql . " Order by rand()";
	}
	
	$sSql = $sSql . " LIMIT 0,1";
	//echo $sSql;
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$PopUpData = stripslashes($data->PopUpFad_text);
		}
	}
	else
	{
		$PopUpData = "No content available in the db with the group name " . $PopUpFad_group . ". Please check the plugin page or in the admin to find more info.";
	}
	

	$PopUpFad_siteurl = get_option('siteurl');
	$PopUpFad_pluginurl = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/";
	$PopUpFad_close = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/close.jpg";
	
	$PopUpFad_txt = $PopUpFad_txt . '<script type="text/javascript" src="'. $PopUpFad_pluginurl . 'PopUpFad.js"></script>';
	$PopUpFad_txt = $PopUpFad_txt . '<link rel="stylesheet" type="text/css" href="'. $PopUpFad_pluginurl . 'PopUpFad.css" />';
	$PopUpFad_txt = $PopUpFad_txt . '<div id="PopUpFad">';
  		$PopUpFad_txt = $PopUpFad_txt . '<div class="PopUpFadClose"><a href="#" onclick="PopUpFadCloseX()"><img src="'. $PopUpFad_close . '" /></a></div>';
  			$PopUpFad_txt = $PopUpFad_txt . '<div>';
				$PopUpFad_txt = $PopUpFad_txt . $PopUpData;
			$PopUpFad_txt = $PopUpFad_txt . '</div>';
		$PopUpFad_txt = $PopUpFad_txt . '</div>';
	$PopUpFad_txt = $PopUpFad_txt . '<script type="text/javascript">PopUpFadOpen();</script>';
	
	
	if(@$PopUpFad_session == "NO")
	{
		return $PopUpFad_txt;
	}
	else
	{
		if ( $_SESSION['PopUpFad_Session'] <> "YES" )
		{
			$_SESSION['PopUpFad_Session'] = "YES"; 
			return $PopUpFad_txt;
		}
	}
	
	
}

register_activation_hook(__FILE__, 'PopUpFad_activation');
add_action('admin_menu', 'PopUpFad_add_to_menu');
add_action("plugins_loaded", "PopUpFad_plugins_loaded");
register_deactivation_hook( __FILE__, 'PopUpFad_deactivate' );


?>