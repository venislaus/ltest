<div class="wrap">
    <h2><?php _e('Update Categoty','conversation_territory'); ?>
        <a class="page-title-action" href="?page=conversation_territory&action=add&s_territory_name=<?php echo $_REQUEST['s_territory_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
        <a class="page-title-action" href="?page=conversation_territory&s_territory_name=<?php echo $_REQUEST['s_territory_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
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
			<table cellspacing="5" cellpadding="5" id="conversation_territory_table">
				<tbody>
					<tr>				
						<td><legend>Territory Name : </legend></td>
						<td> <input type="text" name="territory_name" value="<?php echo set_value('territory_name',$edit_rec['territory_name']); ?>" /> </td>
					</tr>
                   	<tr>
						<td><legend> </legend></td>
						<td> 
                            <input type="hidden" value="<?php echo $edit_rec['id']; ?>" name="territory_id" />
                            <input type="submit" value="Update" class="button bold" name="save_territory_list" />
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

<?php } ?>