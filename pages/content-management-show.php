<?php
// Form submitted, check the data
if (isset($_POST['frm_PopUpFad_display']) && $_POST['frm_PopUpFad_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$PopUpFad_success = '';
	$PopUpFad_success_msg = FALSE;
	
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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('PopUpFad_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_PopUpFad_TABLE."`
					WHERE `PopUpFad_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$PopUpFad_success_msg = TRUE;
			$PopUpFad_success = __('Selected record was successfully deleted.', WP_PopUpFad_UNIQUE_NAME);
		}
	}
	
	if ($PopUpFad_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $PopUpFad_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php echo WP_PopUpFad_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=cool-fade-popup&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = 10;
		$offset = ($pagenum - 1) * $limit;
		$sSql = "SELECT COUNT(PopUpFad_id) AS count FROM ". WP_PopUpFad_TABLE;
		$total = 0;
		$total = $wpdb->get_var($sSql);
		$total = ceil( $total / $limit );
	
		$sSql = "SELECT * FROM `".WP_PopUpFad_TABLE."` order by PopUpFad_id desc LIMIT $offset, $limit";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/cool-fade-popup/pages/setting.js"></script>
		<form name="frm_PopUpFad_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" class="check-column" scope="col"><input type="checkbox" name="PopUpFad_group_item[]" /></th>
			<th width="72%" scope="col">Popup Content</th>
            <th width="16%" scope="col">Popup Group</th>
			<th width="9%" scope="col">Display Status</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="PopUpFad_group_item[]" /></th>
			<th scope="col">Popup Content</th>
            <th scope="col">Popup Group</th>
			<th scope="col">Display Status</th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['PopUpFad_id']; ?>" name="PopUpFad_group_item[]"></td>
						<td><?php echo stripslashes($data['PopUpFad_text']); ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=cool-fade-popup&amp;ac=edit&amp;did=<?php echo $data['PopUpFad_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:_PopUpFad_delete('<?php echo $data['PopUpFad_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
						</div>
						</td>
						<td><?php echo esc_html(stripslashes($data['PopUpFad_group'])); ?></td>
						<td><?php echo esc_html(stripslashes($data['PopUpFad_status'])); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 
			}
			else
			{ 
				?><tr><td colspan="4" align="center">No records available.</td></tr><?php 
			} 
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('PopUpFad_form_show'); ?>
		<input type="hidden" name="frm_PopUpFad_display" value="yes"/>
		<?php
		  $page_links = paginate_links( array(
				'base' => add_query_arg( 'pagenum', '%#%' ),
				'format' => '',
				'prev_text' => __( ' &lt;&lt; ' ),
				'next_text' => __( ' &gt;&gt; ' ),
				'total' => $total,
				'show_all' => False,
				'current' => $pagenum
			) );
		 ?>	
      </form>	
		<div class="tablenav bottom">
			<div class="tablenav-pages"><span class="pagination-links"><?php echo $page_links; ?></span></div>
			<div class="alignleft actions" style="padding-top:8px;">
			  <a class="button" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=cool-fade-popup&amp;ac=add">Add New</a>
			  <a class="button" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=cool-fade-popup&amp;ac=set">Widget setting</a>
			  <a class="button" target="_blank" href="<?php echo WP_PopUpFad_FAV; ?>">Help</a>
			</div>		
		</div>
		<h3>Plugin configuration option</h3>
		<ol>
			<li>Add the plugin in the posts or pages using short code.</li>
			<li>Add directly in to the theme using PHP code.</li>
			<li>Drag and drop the widget to your sidebar.</li>
		</ol>
	 <p class="description"><?php echo WP_PopUpFad_LINK; ?></p>
	</div>
</div>