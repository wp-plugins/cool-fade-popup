<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$PopUpFad_errors = array();
$PopUpFad_success = '';
$PopUpFad_error_found = FALSE;

// Preset the form fields
$form = array(
	'PopUpFad_text' => '',
	'PopUpFad_status' => '',
	'PopUpFad_group' => '',
	'PopUpFad_extra1' => '',
	'PopUpFad_extra2' => '',
	'PopUpFad_date' => ''
);

// Form submitted, check the data
if (isset($_POST['PopUpFad_form_submit']) && $_POST['PopUpFad_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('PopUpFad_form_add');
	
	$form['PopUpFad_text'] = isset($_POST['PopUpFad_text']) ? $_POST['PopUpFad_text'] : '';
	if ($form['PopUpFad_text'] == '')
	{
		$PopUpFad_errors[] = __('Please enter the popup message.', 'cool-fade-popup');
		$PopUpFad_error_found = TRUE;
	}

	$form['PopUpFad_status'] = isset($_POST['PopUpFad_status']) ? $_POST['PopUpFad_status'] : '';
	$form['PopUpFad_group'] = isset($_POST['PopUpFad_group']) ? $_POST['PopUpFad_group'] : '';
	$form['PopUpFad_extra1'] = isset($_POST['PopUpFad_extra1']) ? $_POST['PopUpFad_extra1'] : '';
	$form['PopUpFad_date'] = isset($_POST['PopUpFad_date']) ? $_POST['PopUpFad_date'] : '';

	//	No errors found, we can add this Group to the table
	if ($PopUpFad_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_PopUpFad_TABLE."`
			(`PopUpFad_text`, `PopUpFad_status`, `PopUpFad_group`, `PopUpFad_extra1`, `PopUpFad_date`)
			VALUES(%s, %s, %s, %s, %s)",
			array($form['PopUpFad_text'], $form['PopUpFad_status'], $form['PopUpFad_group'], $form['PopUpFad_extra1'], $form['PopUpFad_date'])
		);
		$wpdb->query($sql);
		
		$PopUpFad_success = __('New details was successfully added.', 'cool-fade-popup');
		
		// Reset the form fields
		$form = array(
			'PopUpFad_text' => '',
			'PopUpFad_status' => '',
			'PopUpFad_group' => '',
			'PopUpFad_extra1' => '',
			'PopUpFad_extra2' => '',
			'PopUpFad_date' => ''
		);
	}
}

if ($PopUpFad_error_found == TRUE && isset($PopUpFad_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $PopUpFad_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($PopUpFad_error_found == FALSE && strlen($PopUpFad_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $PopUpFad_success; ?> 
		<a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=cool-fade-popup"><?php _e('Click here', 'cool-fade-popup'); ?></a> 
		<?php _e(' to view the details', 'cool-fade-popup'); ?></strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Cool fade popup', 'cool-fade-popup'); ?></h2>
	<form name="PopUpFad_form" method="post" action="#" onsubmit="return PopUpFad_submit()"  >
      <h3><?php _e('Add new popup details', 'cool-fade-popup'); ?></h3>
      <label for="tag-image"><?php _e('Enter the popup message', 'cool-fade-popup'); ?></label>
      <textarea name="PopUpFad_text" id="PopUpFad_text" cols="100" rows="9"></textarea>
      <p><?php _e('We Can enter HTML content also', 'cool-fade-popup'); ?></p>
      <label for="tag-select-gallery-group"><?php _e('Select popup group', 'cool-fade-popup'); ?></label>
      <select name="PopUpFad_group" id="PopUpFad_group">
	  <option value='Select'>Select</option>
	  <?php
		$sSql = "SELECT distinct(PopUpFad_group) as PopUpFad_group FROM `".WP_PopUpFad_TABLE."` order by PopUpFad_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["PopUpFad_group"] = strtoupper($DistinctData['PopUpFad_group']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["PopUpFad_group"] = "GROUP" . $j;
		}
		$arrDistinctData[$j+2]["PopUpFad_group"] = "SAMPLE";
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo $arrDistinct["PopUpFad_group"]; ?>'><?php echo $arrDistinct["PopUpFad_group"]; ?></option><?php
		}
		?>
      </select>
      <p><?php _e('This is to group the popup message. Select your popup group.', 'cool-fade-popup'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'cool-fade-popup'); ?></label>
      <select name="PopUpFad_status" id="PopUpFad_status">
        <option value='Select'>Select</option>
		<option value='YES' selected="selected">Yes</option>
        <option value='NO'>No</option>
      </select>
      <p><?php _e('Do you want to show this message into the popup window', 'cool-fade-popup'); ?></p>
	  
	  <label for="tag-display-status"><?php _e('Popup timeout', 'cool-fade-popup'); ?></label>
	  <select name="PopUpFad_extra1" id="PopUpFad_extra1">
		<option value='1000'>1 Second</option>
        <option value='2000' selected="selected">2 Seconds</option>
		<option value='3000'>3 Seconds</option>
		<option value='4000'>4 Seconds</option>
		<option value='6000'>6 Seconds</option>
		<option value='8000'>8 Seconds</option>
		<option value='10000'>10 Seconds</option>
		<option value='12000'>12 Seconds</option>
		<option value='25000'>25 Seconds</option>
		<option value='60000'>60 Seconds</option>
      </select>
	  <p><?php _e('Please select your popup timeout.', 'cool-fade-popup'); ?></p>
	  
		<label for="tag-title"><?php _e('Expiration date', 'cool-fade-popup'); ?></label>
		<input name="PopUpFad_date" type="text" id="PopUpFad_date" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-31 : Is equal to no expire.', 'cool-fade-popup'); ?></p>
	  
      <input name="PopUpFad_id" id="PopUpFad_id" type="hidden" value="">
      <input type="hidden" name="PopUpFad_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Insert Details', 'cool-fade-popup'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_PopUpFad_redirect()" value="<?php _e('Cancel', 'cool-fade-popup'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="PopUpFad_help()" value="<?php _e('Help', 'cool-fade-popup'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('PopUpFad_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'cool-fade-popup'); ?>
	<a target="_blank" href="<?php echo WP_PopUpFad_FAV; ?>"><?php _e('click here', 'cool-fade-popup'); ?></a>
</p>
</div>