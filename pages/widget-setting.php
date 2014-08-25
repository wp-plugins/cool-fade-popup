<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Cool fade popup', 'cool-fade-popup'); ?></h2>
	<h3><?php _e('Widget setting', 'cool-fade-popup'); ?></h3>
    <?php
	$PopUpFad_Title = get_option('PopUpFad_Title');
	$PopUpFad_On_Homepage = get_option('PopUpFad_On_Homepage');
	$PopUpFad_On_Posts = get_option('PopUpFad_On_Posts');
	$PopUpFad_On_Pages = get_option('PopUpFad_On_Pages');
	$PopUpFad_On_Archives = get_option('PopUpFad_On_Archives');
	$PopUpFad_On_Search = get_option('PopUpFad_On_Search');
	$PopUpFad_Group = get_option('PopUpFad_Group');
	$PopUpFad_Session = get_option('PopUpFad_Session');
	$PopUpFad_Random = get_option('PopUpFad_Random');
	$PopUpFad_nopopup = get_option('PopUpFad_nopopup');
	
	if (isset($_POST['PopUpFad_submit'])) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('PopUpFad_form_setting');
			
		$PopUpFad_Title = stripslashes(trim($_POST['PopUpFad_Title']));
		$PopUpFad_On_Homepage = stripslashes(trim($_POST['PopUpFad_On_Homepage']));
		$PopUpFad_On_Posts = stripslashes(trim($_POST['PopUpFad_On_Posts']));
		$PopUpFad_On_Pages = stripslashes(trim($_POST['PopUpFad_On_Pages']));
		$PopUpFad_On_Archives = stripslashes(trim($_POST['PopUpFad_On_Archives']));
		$PopUpFad_On_Search = stripslashes(trim($_POST['PopUpFad_On_Search']));
		$PopUpFad_Group = stripslashes(trim($_POST['PopUpFad_Group']));
		$PopUpFad_Session = stripslashes(trim($_POST['PopUpFad_Session']));
		$PopUpFad_Random = stripslashes(trim($_POST['PopUpFad_Random']));
		$PopUpFad_nopopup = stripslashes(trim($_POST['PopUpFad_nopopup']));
		
		update_option('PopUpFad_Title', $PopUpFad_Title );
		update_option('PopUpFad_On_Homepage', $PopUpFad_On_Homepage );
		update_option('PopUpFad_On_Posts', $PopUpFad_On_Posts );
		update_option('PopUpFad_On_Pages', $PopUpFad_On_Pages );
		update_option('PopUpFad_On_Archives', $PopUpFad_On_Archives );
		update_option('PopUpFad_On_Search', $PopUpFad_On_Search );
		update_option('PopUpFad_Group', $PopUpFad_Group );
		update_option('PopUpFad_Session', $PopUpFad_Session );
		update_option('PopUpFad_Random', $PopUpFad_Random );
		update_option('PopUpFad_nopopup', $PopUpFad_nopopup );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'cool-fade-popup'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/pages/setting.js"></script>
    <form name="ssg_form" method="post" action="">
      
	  <label for="tag-title"><?php _e('Enter widget title', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_Title" id="PopUpFad_Title" type="text" value="<?php echo $PopUpFad_Title; ?>" size="80" maxlength="100" />
      <p><?php _e('Enter widget title, Only for widget.', 'cool-fade-popup'); ?></p>
      
	  <label for="tag-width"><?php _e('Popup on home page', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_On_Homepage" id="PopUpFad_On_Homepage" type="text" value="<?php echo $PopUpFad_On_Homepage; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO, This option is to display the popup on home page.', 'cool-fade-popup'); ?></p>
      
	  <label for="tag-height"><?php _e('Popup on wp posts', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_On_Posts" id="PopUpFad_On_Posts" type="text" value="<?php echo $PopUpFad_On_Posts; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO, This option is to display the popup on wp posts', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('Popup on wp pages', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_On_Pages" id="PopUpFad_On_Pages" type="text" value="<?php echo $PopUpFad_On_Pages; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO, This option is to display the popup on wp pages', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('Popup on wp archives', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_On_Archives" id="PopUpFad_On_Archives" type="text" value="<?php echo $PopUpFad_On_Archives; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('Popup on wp search', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_On_Search" id="PopUpFad_On_Search" type="text" value="<?php echo $PopUpFad_On_Search; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO', 'cool-fade-popup'); ?></p>
	     
	  <label for="tag-height"><?php _e('Select your popup group', 'cool-fade-popup'); ?></label>
	  <select name="PopUpFad_Group" id="PopUpFad_Group">
	 	<?php
		$sSql = "SELECT distinct(PopUpFad_group) as PopUpFad_group FROM `".WP_PopUpFad_TABLE."` order by PopUpFad_group";
		$myDistinctData = array();
		$selected = "";
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		if(count($myDistinctData) > 0)
		{
			foreach ($myDistinctData as $DistinctData)
			{
				$arrDistinctData[$i]["PopUpFad_group"] = strtoupper($DistinctData['PopUpFad_group']);
				$i = $i+1;
			}
			foreach ($arrDistinctData as $arrDistinct)
			{
				if(strtoupper($PopUpFad_Group) == strtoupper($arrDistinct["PopUpFad_group"]) ) 
				{ 
					$selected = "selected='selected'"; 
				}
				?>
				<option value='<?php echo $arrDistinct["PopUpFad_group"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["PopUpFad_group"]); ?></option>
				<?php
				$selected = "";
			}
		}
		else
		{
			?><option value='widget'>Widget</option><?php
		}
		?>
      </select>
      <p><?php _e('Select your group name to display the popup message for widget.', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('Enable Random Option', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_Random" id="PopUpFad_Random" type="text" value="<?php echo $PopUpFad_Random; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO, This is to display popup message randomly', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('Enable Popup Session (Global Setting)', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_Session" id="PopUpFad_Session" type="text" value="<?php echo $PopUpFad_Session; ?>" maxlength="3" />
      <p><?php _e('Enter YES (or) NO, This is to display popup once per session, <br />YES = Display popup once per session.', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-height"><?php _e('No popup text (Global Setting)', 'cool-fade-popup'); ?></label>
      <input name="PopUpFad_nopopup" id="PopUpFad_nopopup" type="text" value="<?php echo $PopUpFad_nopopup; ?>" maxlength="500" size="80" />
      <p><?php _e('This text will be display, if no popup available or all popup expired.', 'cool-fade-popup'); ?></p>
	  
      <br />
	  <input name="PopUpFad_submit" id="PopUpFad_submit" class="button" value="<?php _e('Submit', 'cool-fade-popup'); ?>" type="submit" />
	  <input name="publish" lang="publish" class="button" onclick="_PopUpFad_redirect()" value="<?php _e('Cancel', 'cool-fade-popup'); ?>" type="button" />
      <input name="Help" lang="publish" class="button" onclick="PopUpFad_help()" value="<?php _e('Help', 'cool-fade-popup'); ?>" type="button" />
	  <?php wp_nonce_field('PopUpFad_form_setting'); ?>
    </form>
  </div>
  <br />
  <p class="description">
	<?php _e('Check official website for more information', 'cool-fade-popup'); ?>
	<a target="_blank" href="<?php echo WP_PopUpFad_FAV; ?>"><?php _e('click here', 'cool-fade-popup'); ?></a>
  </p>
</div>