<?php
/*
Plugin Name: Cool fade popup
Plugin URI: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
Description: Sometimes its useful to add a pop up to your website to show your ads, special announcement and for offers. Using this plug-in you can creates unblockable, dynamic and fully configurable popups for your blog.
Author: Gopi Ramasamy
Version: 8.6
Author URI: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
Donate link: http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_PopUpFad_TABLE", $wpdb->prefix . "popupfadpopup");
define('WP_PopUpFad_FAV', 'http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/');

if (!session_id()) { session_start(); }

function PopUpFad()
{
	global $wpdb;
	$PopUpFad_Group = "";
	$PopUpFad_Random = "";
	$PopUpFad_Timeout = 1000;
	$PopUpFad_Group = get_option('PopUpFad_Group');
	$PopUpFad_Random = get_option('PopUpFad_Random');
	
	$sSql = "select PopUpFad_text,PopUpFad_extra1 from ".WP_PopUpFad_TABLE." where PopUpFad_status='YES'";
	$sSql = $sSql . " and ( PopUpFad_date >= NOW() or PopUpFad_date = '0000-00-00 00:00:00')";
	if($PopUpFad_Group <> "")
	{
		 $sSql = $sSql . " and PopUpFad_group='".$PopUpFad_Group."'";
	}
	
	if($PopUpFad_Random == "YES")
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
			$PopUpDataTemp = do_shortcode($PopUpData);
			$PopUpData = $PopUpDataTemp;
			$PopUpFad_Timeout = $data->PopUpFad_extra1;
			if($PopUpFad_Timeout <> "")
			{
				$PopUpFad_Timeout = intval($PopUpFad_Timeout);
			}
			else if($PopUpFad_Timeout == "")
			{
				$PopUpFad_Timeout = 0;
			}
		}
		$PopUpFad_siteurl = get_option('siteurl');
		$PopUpFad_pluginurl = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/";
		$PopUpFad_close = $PopUpFad_siteurl . "/wp-content/plugins/cool-fade-popup/close.jpg";
		if(!is_numeric($PopUpFad_Timeout)) 
		{ 
			$PopUpFad_Timeout = 3000;
		}
		elseif($PopUpFad_Timeout == 0)
		{
			$PopUpFad_Timeout = 3000;
		}
		?>
		<script type="text/javascript" src="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $PopUpFad_pluginurl ; ?>PopUpFad.css" />
		<div id="PopUpFad">
			<div class="PopUpFadClose"><a href="#" onclick="PopUpFadCloseX()"><img src="<?php echo $PopUpFad_close; ?>" /></a></div>
			<div>
			<?php echo $PopUpData; ?>
			</div>
		</div>
		<script type="text/javascript">
		setTimeout('PopUpFadOpen()', <?php echo $PopUpFad_Timeout; ?>);
		</script>
		<?php
	}
	else
	{
		$PopUpFad_nopopup = get_option('PopUpFad_nopopup');
		echo $PopUpFad_nopopup;
	}
}


function PopUpFad_activation()
{
	global $wpdb;
	$c1 = '<div>';
	$c1 = $c1.'<strong>Cool fading popup demo</strong><br />';
	$c1 = $c1.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="gopiplus" src="http://www.gopiplus.com/work/wp-content/uploads/pluginimages/img/gopiplus.com-popup.png" alt="gopiplus" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	$c1 = $c1.'</div>';
	
	$c2 = '<div>';
	$c2 = $c2.'<strong>Cool fading popup plugin</strong><br />';
	$c2 = $c2.'<p align="left"><img style="margin: 5px;text-align:left;float:left;" title="gopiplus" src="http://www.gopiplus.com/work/wp-content/uploads/pluginimages/img/gopiplus.com-popup.png" alt="gopiplus" />This is the demo for cool fade popup plugin. using this plugin you can add this cool popup window into your wordpress website. using this unblockable popup window  you can add your ads, special information, offers and announcements. Close this popup and read the article you can easily configure this plugin in your wordpress website. its very simple. please feel free to post you comments and feedback.</p>';
	$c2 = $c2.'</div>';
	
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
		$sSql = $iIns . " VALUES ('$c1', 'YES', 'WIDGET', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . " VALUES ('$c2', 'YES', 'SAMPLE', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('PopUpFad_Title', "Cool fade popup");
	add_option('PopUpFad_On_Homepage', "YES");
	add_option('PopUpFad_On_Posts', "YES");
	add_option('PopUpFad_On_Pages', "YES");
	add_option('PopUpFad_On_Archives', "YES");
	add_option('PopUpFad_On_Search', "YES");
	add_option('PopUpFad_Group', "SAMPLE");
	add_option('PopUpFad_Random', "YES");
	add_option('PopUpFad_Session', "NO");
	add_option('PopUpFad_nopopup', "No popup available or all popup expired.");
}

function PopUpFad_deactivate() 
{
	// No action required.
}

function PopUpFad_add_to_menu() 
{
	add_options_page(__('Cool fade popup', 'cool-fade-popup'), __('Cool fade popup', 'cool-fade-popup'), 'manage_options', 'cool-fade-popup', 'PopUpFad_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'PopUpFad_add_to_menu');
}

function PopUpFad_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/widget-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function PopUpFad_plugins_loaded()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('cool-fade-popup', 'Cool fade popup', 'PopUpFad_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('cool-fade-popup', array('Cool fade popup', 'widgets'), 'PopUpFad_widget_control');
	} 
}

function PopUpFad_widget_control() 
{
	echo '<br />';
	_e('Cool fade popup', 'cool-fade-popup');
	echo '.&nbsp;';
	_e('Check official website for more information', 'cool-fade-popup');
	?>&nbsp;<a target="_blank" href="<?php echo WP_PopUpFad_FAV; ?>"><?php _e('click here', 'cool-fade-popup'); ?></a><br /><br /><?php
	
}

function PopUpFad_widget($args) 
{
	$display = "";
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
		if ( isset($_SESSION['PopUpFad_Session']) <> "YES" )
		{
			$_SESSION['PopUpFad_Session'] = "YES"; 
			if($display == "show")
			{
				PopUpFad();
			}
		}
	}
	
}

add_shortcode( 'cool-fade-popup', 'PopUpFad_filter_shortcode' );

function PopUpFadeNew( $group = "", $random = "", $session = "" )
{
	$ArrInput = array();
	$ArrInput["group"] = $group;
	$ArrInput["random"] = $random;
	$ArrInput["session"] = $session;
	echo PopUpFad_filter_shortcode( $ArrInput );
}

function PopUpFad_filter_shortcode( $atts ) 
{
	global $wpdb;
	//PopUpFad=GROUP=widget:RANDOM=YES:SESSION=NO --> Old Version
	
	$PopUpFad_txt = "";
	$PopUpFad_group = "";
	$PopUpFad_random = "";
	$PopUpFad_session = "";
	$PopUpFad_Timeout = 1000;
	//[cool-fade-popup group="widget" random="YES" session="NO"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$PopUpFad_group = $atts['group'];
	$PopUpFad_random = $atts['random'];
	$PopUpFad_session = $atts['session'];
	
	$sSql = "select PopUpFad_text,PopUpFad_extra1 from ".WP_PopUpFad_TABLE." where PopUpFad_status='YES'";
	$sSql = $sSql . " and ( PopUpFad_date >= NOW() or PopUpFad_date = '0000-00-00 00:00:00')";
	if($PopUpFad_group <> "")
	{
		 $sSql = $sSql . " and PopUpFad_group='".$PopUpFad_group."'";
	}
	
	if($PopUpFad_random == "YES")
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
			$PopUpDataTemp = do_shortcode($PopUpData);
			$PopUpData = $PopUpDataTemp;
			
			$PopUpFad_Timeout = $data->PopUpFad_extra1;
			if($PopUpFad_Timeout <> "")
			{
				$PopUpFad_Timeout = intval($PopUpFad_Timeout);
			}
			else if($PopUpFad_Timeout == "")
			{
				$PopUpFad_Timeout = 0;
			}
		}
		if(!is_numeric($PopUpFad_Timeout)) 
		{ 
			$PopUpFad_Timeout = 3000;
		}
		elseif($PopUpFad_Timeout == 0)
		{
			$PopUpFad_Timeout = 3000;
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
		$PopUpFad_txt = $PopUpFad_txt . '<script type="text/javascript">';
		$PopUpFad_txt = $PopUpFad_txt." setTimeout('PopUpFadOpen()', ".$PopUpFad_Timeout.");";
		$PopUpFad_txt = $PopUpFad_txt.'</script>';
		
		if($PopUpFad_session == "NO")
		{
			return $PopUpFad_txt;
		}
		else
		{
			if ( isset($_SESSION['PopUpFad_Session']) <> "YES" )
			{
				$_SESSION['PopUpFad_Session'] = "YES"; 
				return $PopUpFad_txt;
			}
		}

	}
	else
	{
		$PopUpFad_nopopup = get_option('PopUpFad_nopopup');
		$PopUpFad_txt = $PopUpFad_nopopup;
		return $PopUpFad_txt;
	}
}

function PopUpFad_textdomain() 
{
	  load_plugin_textdomain( 'cool-fade-popup', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'PopUpFad_textdomain');
register_activation_hook(__FILE__, 'PopUpFad_activation');
add_action('admin_menu', 'PopUpFad_add_to_menu');
add_action("plugins_loaded", "PopUpFad_plugins_loaded");
register_deactivation_hook( __FILE__, 'PopUpFad_deactivate' );
?>