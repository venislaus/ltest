<div class="wrap">
    <h2><?php _e('Update Outcome','conversation_outcome'); ?>
        <a class="page-title-action" href="?page=conversation_outcome&action=add&s_outcome_name=<?php echo $_REQUEST['s_outcome_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
        <a class="page-title-action" href="?page=conversation_outcome&s_outcome_name=<?php echo $_REQUEST['s_outcome_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>
<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<?php if(!empty($edit_rec)){ ?>
<form enctype="multipart/form-data" class="adminAddEdit" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5" id="conversation_outcome_table">
				<tbody>
					<tr>				
						<td><legend>Outcome Name : </legend></td>
						<td> <input type="text" name="outcome_name" value="<?php echo set_value('outcome_name',$edit_rec['outcome_name']); ?>" /> </td>
					</tr>
                    <?php if(!empty($edit_rec['outcome_image'])){?>
                    <tr>
                        <td valign="top"><legend>Exisiting Image : </legend></td>
                        <td>
                            <img src="<?php echo plugins_url() ."/conversations/images/outcome/thumbsize1/".$edit_rec['id']."/".$edit_rec['outcome_image']; ?>">
                            <input type="hidden" name="hid_outcome_image" value="<?php echo set_value('outcome_image',$edit_rec['outcome_image']); ?>" />
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><legend>Image : </legend></td>
                        <td> <input type="file" name="outcome_image" value="" /> </td>
                    </tr>
                   	<tr>
						<td><legend> </legend></td>
						<td> 
                            <input type="hidden" value="<?php echo $edit_rec['id']; ?>" name="outcome_id" />
                            <input type="submit" value="Update" class="button bold" name="save_outcome_list" />
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

<?php } ?>