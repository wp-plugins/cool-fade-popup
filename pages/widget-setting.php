<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_PopUpFad_TITLE; ?></h2>
	<h3>Widget setting</h3>
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
	
	if (@$_POST['PopUpFad_submit']) 
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
		
		update_option('PopUpFad_Title', $PopUpFad_Title );
		update_option('PopUpFad_On_Homepage', $PopUpFad_On_Homepage );
		update_option('PopUpFad_On_Posts', $PopUpFad_On_Posts );
		update_option('PopUpFad_On_Pages', $PopUpFad_On_Pages );
		update_option('PopUpFad_On_Archives', $PopUpFad_On_Archives );
		update_option('PopUpFad_On_Search', $PopUpFad_On_Search );
		update_option('PopUpFad_Group', $PopUpFad_Group );
		update_option('PopUpFad_Session', $PopUpFad_Session );
		update_option('PopUpFad_Random', $PopUpFad_Random );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/pages/setting.js"></script>
    <form name="ssg_form" method="post" action="">
      
	  <label for="tag-title">Enter widget title</label>
      <input name="PopUpFad_Title" id="PopUpFad_Title" type="text" value="<?php echo $PopUpFad_Title; ?>" size="80" maxlength="100" />
      <p>Enter widget title, Only for widget.</p>
      
	  <label for="tag-width">Popup on home page</label>
      <input name="PopUpFad_On_Homepage" id="PopUpFad_On_Homepage" type="text" value="<?php echo $PopUpFad_On_Homepage; ?>" maxlength="3" />
      <p>Enter YES (or) NO, This option is to display the popup on home page.</p>
      
	  <label for="tag-height">Popup on wp posts</label>
      <input name="PopUpFad_On_Posts" id="PopUpFad_On_Posts" type="text" value="<?php echo $PopUpFad_On_Posts; ?>" maxlength="3" />
      <p>Enter YES (or) NO, This option is to display the popup on wp posts</p>
	  
	  <label for="tag-height">Popup on wp pages</label>
      <input name="PopUpFad_On_Pages" id="PopUpFad_On_Pages" type="text" value="<?php echo $PopUpFad_On_Pages; ?>" maxlength="3" />
      <p>Enter YES (or) NO, This option is to display the popup on wp pages</p>
	  
	  <label for="tag-height">Popup on wp archives</label>
      <input name="PopUpFad_On_Archives" id="PopUpFad_On_Archives" type="text" value="<?php echo $PopUpFad_On_Archives; ?>" maxlength="3" />
      <p>Enter YES (or) NO</p>
	  
	  <label for="tag-height">Popup on wp search</label>
      <input name="PopUpFad_On_Search" id="PopUpFad_On_Search" type="text" value="<?php echo $PopUpFad_On_Search; ?>" maxlength="3" />
      <p>Enter YES (or) NO</p>
	     
	  <label for="tag-height">Select your popup group</label>
	  <select name="ssg_type" id="ssg_type">
	 	<?php
		$sSql = "SELECT distinct(PopUpFad_group) as PopUpFad_group FROM `".WP_PopUpFad_TABLE."` order by PopUpFad_group";
		$myDistinctData = array();
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
				if(strtoupper($PopUpFad_group) == strtoupper($arrDistinct["PopUpFad_group"]) ) 
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
      <p>Select your group name to display the popup message for widget.</p>
	  
	  <label for="tag-height">Enable Popup Session</label>
      <input name="PopUpFad_Session" id="PopUpFad_Session" type="text" value="<?php echo $PopUpFad_Session; ?>" maxlength="3" />
      <p>Enter YES (or) NO, This is to display popup once per session, <br />YES = Display popup once per session.</p>
	  
	  <label for="tag-height">Enable Random Option</label>
      <input name="PopUpFad_Random" id="PopUpFad_Random" type="text" value="<?php echo $PopUpFad_Random; ?>" maxlength="3" />
      <p>Enter YES (or) NO, This is to display popup message randomly</p>
	  
      <br />
	  <input name="PopUpFad_submit" id="PopUpFad_submit" class="button" value="Submit" type="submit" />
	  <input name="publish" lang="publish" class="button" onclick="_PopUpFad_redirect()" value="Cancel" type="button" />
      <input name="Help" lang="publish" class="button" onclick="PopUpFad_help()" value="Help" type="button" />
	  <?php wp_nonce_field('PopUpFad_form_setting'); ?>
    </form>
  </div>
  <br /><p class="description"><?php echo WP_PopUpFad_LINK; ?></p>
</div>
