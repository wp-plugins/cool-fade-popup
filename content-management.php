<!--
##########################################################################################################
###### Project   : Cool fade popup  																######
###### File Name : content-management.php                   										######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        					######
###### Link      : http://www.gopiplus.com/work/2011/01/08/cool-fade-popup/    						######
##########################################################################################################
-->

<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=cool-fade-popup/content-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['PopUpFad_text']) <>"")
    {
			if($_POST['PopUpFad_id'] == "" )
			{
					$sql = "insert into ".WP_PopUpFad_TABLE.""
					. " set `PopUpFad_text` = '" . mysql_real_escape_string(trim($_POST['PopUpFad_text']))
					. "', `PopUpFad_status` = '" . $_POST['PopUpFad_status']
					. "', `PopUpFad_group` = '" . $_POST['PopUpFad_group']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_PopUpFad_TABLE.""
					. " set `PopUpFad_text` = '" . mysql_real_escape_string(trim($_POST['PopUpFad_text']))
					. "', `PopUpFad_status` = '" . $_POST['PopUpFad_status']
					. "', `PopUpFad_group` = '" . $_POST['PopUpFad_group']
					. "' where `PopUpFad_id` = '" . $_POST['PopUpFad_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_PopUpFad_TABLE." where PopUpFad_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_PopUpFad_TABLE." where PopUpFad_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $PopUpFad_id_x = htmlspecialchars(stripslashes($data->PopUpFad_id)); 
        if ( !empty($data) ) $PopUpFad_text_x = htmlspecialchars(stripslashes($data->PopUpFad_text));
        if ( !empty($data) ) $PopUpFad_status_x = htmlspecialchars(stripslashes($data->PopUpFad_status));
		if ( !empty($data) ) $PopUpFad_group_x = htmlspecialchars(stripslashes($data->PopUpFad_group));
        $submittext = "Update Message";
    }
    ?>
  <h2>Cool fade popup</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/setting.js"></script> 
  <form name="PopUpFad_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return PopUpFad_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the popup message (Can enter HTML content also):</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle"><textarea name="PopUpFad_text" id="PopUpFad_text" cols="120" rows="15"><?php echo @$PopUpFad_text_x; ?></textarea></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Group Name:</td>
      </tr>
      <tr>
        <td width="11%" align="left" valign="middle"><select name="PopUpFad_status" id="PopUpFad_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$PopUpFad_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$PopUpFad_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select></td>
        <td width="89%" align="left" valign="middle"><input name="PopUpFad_group" type="text" id="PopUpFad_group" value="<?php echo @$PopUpFad_group_x; ?>" size="20" maxlength="75" /></td>
      </tr>
      <tr>
        <td height="35" colspan="3" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="_PopUpFad_redirect()" value="Cancel" type="button" /></td>
              <td width="50%" align="right"><div style="float:right;">
                  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/content-management.php'" value="Go to - Content Management" type="button" />
                  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/cool-fade-popup.php'" value="Go to - Popup Setting" type="button" />
                </div></td>
            </tr>
          </table></td>
      </tr>
      <input name="PopUpFad_id" id="PopUpFad_id" type="hidden" value="<?php echo @$PopUpFad_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_PopUpFad_TABLE." order by PopUpFad_id");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="PopUpFad_Display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" align="left" scope="col">ID</th>
            <th width="65%" align="left" scope="col">Popup Content</th>
            <th width="11%" align="left" scope="col">Group</th>
            <th width="7%" align="left" scope="col">Display</th>
            <th width="8%" align="left" scope="col">Action</th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->PopUpFad_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->PopUpFad_id)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->PopUpFad_text)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->PopUpFad_group)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->PopUpFad_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=cool-fade-popup/content-management.php&DID=<?php echo($data->PopUpFad_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_PopUpFad_delete('<?php echo($data->PopUpFad_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <div style="float:right;">
    <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/content-management.php'" value="Go to - Content Management" type="button" />
    <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=cool-fade-popup/cool-fade-popup.php'" value="Go to - Popup Setting" type="button" />
  </div>
  <?php include_once("help.php"); ?>
</div>
