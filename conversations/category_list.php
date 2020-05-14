<style>
    th,td{
        white-space: nowrap;
    }
    .orderDrag{
        width: 20px;
        height: auto;
    }
</style>
<?php $items = $conversation_category_items; ?>
<div class="wrap">
    <h1>Category
        <a class="page-title-action" href="?page=conversation_category&action=add&s_category_name=<?php echo $_REQUEST['s_category_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"> Add New </a>
    </h1>
</div>
<form name="category_list" id="category_list" class="admin_style" action="" method="POST">
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
        <input type="text" name="s_category_name" value="<?php echo (isset($_REQUEST['s_category_name']))? $_REQUEST['s_category_name'] : ''; ?>" placeholder="Category Name" />
        <input class="button" type="submit" value="Search" name="search_category_list">
        <input class="button" type="button" name="btnreset" value="Reset" onclick="window.location.href='?page=conversation_category'" />
    </div>
    <div>
        <input class="button" type="submit" value="Update Order" name="update_category_ordering">
    </div>
<?php } ?>
<table id="all_category_lists" cellspacing="0" width="100%" class="wp-list-table widefat ">
	<thead>
		<tr>
			<th width="5%" style="text-align:center" class="manage-column column-username sortable desc" scope="col"><input type="checkbox" name="cb_all" /></th>
			<th style="text-align:left" class="manage-column column-username sortable desc" id="username" scope="col">
                <span>
                    <?php
                     $n_sortorder = "asc";
                     if($_REQUEST['sortby'] == "category_name" && $_REQUEST['sortorder'] == "asc"){
                         $n_sortorder = "desc";
                     }
                    ?>
                <a href="?page=conversation_category&s_category_name=<?php echo $_REQUEST['s_category_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=category_name&sortorder=<?=$n_sortorder?>">Category Name</a>
                </span>
            </th>
            <th width="10%" style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Image</span></th>
			<th width="10%" style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Actions</span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
            <th></th> <th></th> <th></th><th></th>
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
                    <?php echo $item['category_name']; ?>
                </td>
                <td style="text-align:left" class="input_name">
                    <?php
                    if(!empty($item['category_image'])){
                    ?>
                    <img src="<?php echo plugins_url() ."/conversations/images/category/thumbsize2/".$item['id']."/".$item['category_image']; ?>">
                    <?php } ?>
                </td>
                <td style="text-align:center" class="input_name">
				    <a href="?page=conversation_category&action=edit&category_id=<?php echo $item['id']; ?>&s_category_name=<?php echo $_REQUEST['s_category_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=<?php echo $_REQUEST['sortby']; ?>&sortorder=<?php echo $_REQUEST['sortorder']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <img src="<?php echo plugins_url() ."/conversations/images/drag.png";?>" class="orderDrag">
				</td>
			</tr> 
           
		<?php } ?>
            <tr>
                <td colspan="6" class="check" scope="row" style="margin: 4px;">
                    <div>
                        <input class="button" type="submit" value="Update Order" name="update_category_ordering">
                    </div>
                </td>
            </tr>
            <?php /*<tr>
				 <td colspan="6" class="check" scope="row" style="margin: 4px;"><?php echo $p->show(); ?></td>
			</tr>*/?>
		<?php }else{ ?>
			<tr>
				 <td colspan="8" class="check" scope="row" style="margin: 4px;">No category available</td>
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
    $("#all_category_lists tbody").sortable({
        appendTo: "parent",
        helper: "clone"
    });
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
    $('#category_list').submit(function(){
        if($('select[name=action]').val()=='delete'){
            if(confirm('Sure want to delete?.'))
                return true;
            else    
                return false;
        }
    });
});
</script>