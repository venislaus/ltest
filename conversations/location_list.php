<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<style>
    th,td{
        white-space: nowrap;
    }
    .orderDrag{
        width: 20px;
        height: auto;
    }
</style>
<?php $items = $conversation_location_items; ?>
<div class="wrap">
    <h1>Location
        <a class="page-title-action" href="?page=conversation_location&action=add&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
    </h1>
</div>
<form name="location_list" id="location_list" class="admin_style" action="" method="POST">
<?php if(!empty($items)){?>
    <div class="actions">
        <select name="action">
            <option value="">Bulk Actions</option>
            <option value="delete">Delete</option>
        </select>
        <input class="button" type="submit" name="submit_action" value="Go" />
        <input type="hidden" value="<?php echo $_REQUEST['paging']; ?>" name="paging" />
        <input type="hidden" value="<?php echo $_REQUEST['sortby']; ?>" name="sortby" />
        <input type="hidden" value="<?php echo $_REQUEST['sortorder']; ?>" name="sortorder" />
        <input type="text" name="s_location_name" value="<?php echo (isset($_REQUEST['s_location_name']))? $_REQUEST['s_location_name'] : ''; ?>" placeholder="Location Name" />
        <input class="button" type="submit" value="Search" name="search_location_list">
        <input class="button" type="button" name="btnreset" value="Reset" onclick="window.location.href='?page=conversation_location'" />
    </div>
<?php } ?>
<table id="all_location_lists" cellspacing="0" width="100%" class="wp-list-table widefat">
	<thead>
		<tr>
			<th width="5%" style="text-align:center" class="manage-column column-username sortable desc" scope="col"><input type="checkbox" name="cb_all" /></th>
			<th style="text-align:left" class="manage-column column-username sortable desc" id="username" scope="col">
                <span>
                    <?php
                     $n_sortorder = "asc";
                     if($_REQUEST['sortby'] == "location_name" && $_REQUEST['sortorder'] == "asc"){
                         $n_sortorder = "desc";
                     }
                    ?>
                <a href="?page=conversation_location&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=location_name&sortorder=<?=$n_sortorder?>">Location Name</a>
                </span>
            </th>
			<th width="10%" style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Actions</span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
            <th></th> <th></th> <th></th>
		</tr>
	</tfoot>

	<tbody class="list:user" id="the-list">
    <?php
		if(!empty($items)){
			foreach($items as $item) {
		?>
			<tr >	
				 <td style="text-align:center" class="input_name">
                    <input class="cb_item" type="checkbox" name="cb_item[]" value="<?php echo $item['id']; ?>" />
                     <input type="hidden" name="list_ordering_ids[]" value="<?php echo $item['id']; ?>">
				</td>
                <td  style="text-align:left" class="input_name cat-name">
                    <?php echo $item['location_name']; ?>
                </td>
                <td style="text-align:center" class="input_name">
				    <a href="?page=conversation_location&action=edit&location_id=<?php echo $item['id']; ?>&s_location_name=<?php echo $_REQUEST['s_location_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
				</td>
			</tr> 
           
		<?php } ?>
            <tr>
				 <td colspan="6" class="check" scope="row" style="margin: 4px;"><?php echo $p->show(); ?></td>
			</tr>
		<?php }else{ ?>
			<tr>
				 <td colspan="8" class="check" scope="row" style="margin: 4px;">No location available</td>
			</tr>
		<?php }
	?>       
		
	</tbody>
</table>
</form>