<div class="wrap">
    <h2><?php _e('Add Category','conversation_category'); ?>
        <a class="page-title-action" href="?page=conversation_category&s_category_name=<?php echo $_REQUEST['s_category_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> View Listing </a>
    </h2>
</div>
<?php if(!empty($result_message)){ ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong><?php echo $result_message; ?></strong></p></div>
<?php } ?>

<form enctype="multipart/form-data" class="adminAddEdit" action="" method="post">

	<div class="postbox" id="linkadvanceddiv">
		<div class="inside" style="float: left; width: 98%; clear: both;">
			<table cellspacing="5" cellpadding="5" id="conversation_category_form_table">
				<tbody>
					<tr>
                        <td><legend>Category Name : </legend></td>
                        <td> <input type="text" name="category_name" value="<?php echo set_value('category_name'); ?>" /> </td>
                    </tr>
                    <tr>
                        <td><legend>Image : </legend></td>
                        <td> <input type="file" name="category_image" value="" /> </td>
                    </tr>
                    </table> </td></tr>
					<tr>				
						<td><legend> </legend></td>
						<td>
                            <input type="submit" value="Save" class="button bold" name="save_category_list" /> </td>
					</tr>
					
				</tbody>
			</table>
		</div>
		<div style="clear:both; height:1px;">&nbsp;</div>
	</div>
	
</form>

