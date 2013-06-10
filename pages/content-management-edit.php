<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_PopUpFad_TABLE."
	WHERE `PopUpFad_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$PopUpFad_errors = array();
	$PopUpFad_success = '';
	$PopUpFad_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_PopUpFad_TABLE."`
		WHERE `PopUpFad_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'PopUpFad_text' => $data['PopUpFad_text'],
		'PopUpFad_status' => $data['PopUpFad_status'],
		'PopUpFad_group' => $data['PopUpFad_group'],
		'PopUpFad_extra1' => $data['PopUpFad_extra1'],
		'PopUpFad_extra2' => $data['PopUpFad_extra2']
	);
}
// Form submitted, check the data
if (isset($_POST['PopUpFad_form_submit']) && $_POST['PopUpFad_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('PopUpFad_form_edit');
	
	$form['PopUpFad_text'] = isset($_POST['PopUpFad_text']) ? $_POST['PopUpFad_text'] : '';
	if ($form['PopUpFad_text'] == '')
	{
		$PopUpFad_errors[] = __('Please enter the popup message.', WP_PopUpFad_UNIQUE_NAME);
		$PopUpFad_error_found = TRUE;
	}

	$form['PopUpFad_status'] = isset($_POST['PopUpFad_status']) ? $_POST['PopUpFad_status'] : '';
	$form['PopUpFad_group'] = isset($_POST['PopUpFad_group']) ? $_POST['PopUpFad_group'] : '';

	//	No errors found, we can add this Group to the table
	if ($PopUpFad_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_PopUpFad_TABLE."`
				SET `PopUpFad_text` = %s,
				`PopUpFad_status` = %s,
				`PopUpFad_group` = %s
				WHERE PopUpFad_id = %d
				LIMIT 1",
				array($form['PopUpFad_text'], $form['PopUpFad_status'], $form['PopUpFad_group'], $did)
			);
		$wpdb->query($sSql);
		
		$PopUpFad_success = 'Details was successfully updated.';
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
    <p><strong><?php echo $PopUpFad_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=cool-fade-popup">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_PopUpFad_TITLE; ?></h2>
	<form name="PopUpFad_form" method="post" action="#" onsubmit="return PopUpFad_submit()"  >
      <h3>Update popup details</h3>
	  <label for="tag-image">Enter the popup message</label>
      <textarea name="PopUpFad_text" id="PopUpFad_text" cols="130" rows="9"><?php echo esc_html(stripslashes($form['PopUpFad_text'])); ?></textarea>
      <p>We Can enter HTML content also</p>
      <label for="tag-select-gallery-group">Select popup group</label>
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
			if(strtoupper($form['PopUpFad_group']) == strtoupper($arrDistinct["PopUpFad_group"]) ) 
			{ 
				$selected = "selected='selected'"; 
			}
			?>
			<option value='<?php echo $arrDistinct["PopUpFad_group"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["PopUpFad_group"]); ?></option>
			<?php
			$selected = "";
		}
		?>
      </select>
      <p>This is to group the popup message. Select your popup group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="PopUpFad_status" id="PopUpFad_status">
        <option value='Select'>Select</option>
		<option value='YES' <?php if($form['PopUpFad_status']=='YES') { echo 'selected="selected"' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['PopUpFad_status']=='NO') { echo 'selected="selected"' ; } ?>>No</option>
      </select>
      <p>Do you want to show this message into the popup window</p>
      <input name="PopUpFad_id" id="PopUpFad_id" type="hidden" value="">
      <input type="hidden" name="PopUpFad_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="_PopUpFad_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="PopUpFad_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('PopUpFad_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo WP_PopUpFad_LINK; ?></p>
</div>