<div class="wrap">
    <h2><?php _e('Add Activity Type','conversation_activity'); ?>
        <a class="page-title-action" href="?page=conversation_activity&s_activity_name=<?php echo $_REQUEST['s_activity_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>
<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<form enctype="multipart/form-data" class="adminAddEdit" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5" id="conversation_activity_form_table">
				<tbody>
					<tr>
                        <td><legend>Activity Type : </legend></td>
                        <td> <input type="text" name="activity_name" value="<?php echo set_value('activity_name'); ?>" /> </td>
                    </tr>
                    </table> </td></tr>
					<tr>				
						<td><legend> </legend></td>
						<td>
                            <input type="submit" value="Save" class="button bold" name="save_activity_list" /> </td>
					</tr>
					
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

