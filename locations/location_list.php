<style>
    th,td{
        white-space: nowrap;
    }
</style>
<div class="wrap">
    <h1>Locations
        <a class="page-title-action" href="?page=locations&action=add&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
    </h1>
</div>
<?php if(!empty($result_message)){ ?>
    <div class="updated settings-error" id="setting-error-settings_updated">
        <p><strong><?php echo $result_message; unset($result_message); ?></strong></p></div>
<?php } ?>
<form name="locations" id="locations" class="admin_style" action="" method="POST">
<div class="actions">
<select name="action">
    <option value="">Bulk Actions</option>
    <option value="delete">Delete</option>
</select>
<input class="go_button" type="submit" name="submit_action" value="Go" />
<input type="hidden" value="<?php echo $_REQUEST['paging']; ?>" name="paging" />
<input type="hidden" value="<?php echo $_REQUEST['sortby']; ?>" name="sortby" />
<input type="hidden" value="<?php echo $_REQUEST['sortorder']; ?>" name="sortorder" />
<input type="text" name="s_location_name" value="<?php echo (isset($_REQUEST['s_location_name']))? $_REQUEST['s_location_name'] : ''; ?>" placeholder="Location name" />
<input class="button" type="submit" value="Search" name="search_locations">
<input class="" type="button" name="btnreset" value="Reset" onclick="window.location.href='?page=locations'" />
</div>
<table id="all_locations_lists" cellspacing="0" width=100% class="wp-list-table widefat ">
	<thead>
		<tr>
			<th width=5% style="text-align:center" class="manage-column column-username sortable desc" scope="col"><input type="checkbox" name="cb_all" /></th>
			<th style="text-align:left" class="manage-column column-username sortable desc" id="username" scope="col">
                <span>
                    <?php
                     $n_sortorder = "asc";
                     if($_REQUEST['sortby'] == "location_name" && $_REQUEST['sortorder'] == "asc"){
                         $n_sortorder = "desc";
                     }
                    ?>
                <a href="?page=locations&action=add&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=location_name&sortorder=<?=$n_sortorder?>">Name</a>
                </span>
            </th>
			<th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Actions</span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
            <th></th> <th></th> <th></th>
		</tr>
	</tfoot>

	<tbody class="list:user" id="the-list">
    <?php
        $items = $location_items;
		if(!empty($items)){
			foreach($items as $item) {
		?>
			<tr >	
				 <td style="text-align:center" class="input_name">
                    <input class="cb_item" type="checkbox" name="cb_item[]" value="<?php echo $item['id']; ?>" />
				</td>             			
				 <td  style="text-align:left" class="input_name cat-name">
					<?php echo stripslashes($item['location_name']); ?>
				</td>
				 <td style="text-align:center" class="input_name">
                    <a href="?page=locations&action=edit&location_id=<?php echo $item['id']; ?>&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
				</td>
			</tr> 
           
		<?php } ?>
		<?php }else{ ?>
			<tr>
				 <td colspan="2" class="check" scope="row" style="margin: 4px;">No location available</td>
			</tr>
		<?php }
	?>       
		
	</tbody>
</table>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
// anonymous function to pass in the jquery object. The usual $(document)... throws a "$ is not a function error".
jQuery(function($){
    // to check and uncheck records in bulk
    $('input[name=cb_all]').click(function(){
        if($('input[name=cb_all]').is(':checked')){
            $('input[class=cb_item]').attr('checked', true); 
       }
       else{
            $('input[class=cb_item]').attr('checked', false);         
       }
    });
    
    // validate form on submit
    $('#locations').submit(function(){
        if($('select[name=action]').val()=='delete'){
            if(confirm('Sure want to delete?.'))
                return true;
            else    
                return false;
        }
    });
});
</script>