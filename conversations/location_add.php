<div class="wrap">
    <h2><?php _e('Add Location','conversation_location'); ?>
        <a class="page-title-action" href="?page=conversation_location&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>
<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<form enctype="multipart/form-data" class="adminAddEdit" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5" id="conversation_location_form_table">
				<tbody>
					<tr>
                        <td><legend>Location Name : </legend></td>
                        <td> <input type="text" name="location_name" value="<?php echo set_value('location_name'); ?>" /> </td>
                    </tr>
                    </table> </td></tr>
					<tr>				
						<td><legend> </legend></td>
						<td>
                            <input type="submit" value="Save" class="button bold" name="save_location_list" /> </td>
					</tr>
					
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

