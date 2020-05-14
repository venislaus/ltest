<div class="wrap">
	<h2><?php _e('Update Location','locations'); ?>
        <a class="page-title-action" href="?page=locations&action=add&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
        <a class="page-title-action" href="?page=locations&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>

<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<?php if(!empty($edit_rec)){ ?>
<form enctype="multipart/form-data" class="adminAddEdit admin_style" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5">
				<tbody>
					<tr>				
						<td><legend>Name : </legend></td>
						<td> <input type="text" name="location_name" value="<?php echo stripslashes(set_value('location_name',$edit_rec['location_name'])); ?>" /> </td>
					</tr>
                    <tr>
                        <td><legend>Timings : </legend></td>
                        <td> <input type="text" name="location_timings" value="<?php echo set_value('location_timings',$edit_rec['location_timings']); ?>" /> </td>
                    </tr>
                    <tr>
                        <td><legend>Phone : </legend></td>
                        <td> <input type="text" name="phone" value="<?php echo set_value('phone',$edit_rec['phone']); ?>" /> </td>
                    </tr>
				</tbody>
			</table>
            <table>
                <tr>
                    <td><legend> </legend></td>
                    <td>
                        <input type="hidden" value="<?php echo $edit_rec['id']; ?>" name="location_id" />
                        <input type="submit" value="Update" class="button bold" name="save_locations" />
                    </td>
                </tr>
            </table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>
<?php } ?>