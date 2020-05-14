<div class="wrap">
    <h2><?php _e('Add Role','conversation_role'); ?>
        <a class="page-title-action" href="?page=conversation_role&s_role_name=<?php echo $_REQUEST['s_role_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>
<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<form enctype="multipart/form-data" class="adminAddEdit" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5" id="conversation_role_form_table">
				<tbody>
					<tr>
                        <td><legend>Role Name : </legend></td>
                        <td> <input type="text" name="role_name" value="<?php echo set_value('role_name'); ?>" /> </td>
                    </tr>
                    </table> </td></tr>
					<tr>				
						<td><legend> </legend></td>
						<td>
                            <input type="submit" value="Save" class="button bold" name="save_role_list" /> </td>
					</tr>
					
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

