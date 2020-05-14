<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<style>
    th,td{
        white-space: nowrap;
    }
</style>
<div class="wrap">
    <h1>Conversations Tracker</h1>
</div>
<?php if(!empty($result_message)){ ?>
    <div class="updated settings-error" id="setting-error-settings_updated">
        <p><strong><?php echo $result_message; unset($result_message); ?></strong></p></div>
<?php } ?>
<form name="conversations" id="conversations" class="admin_style" action="" method="POST">
<div class="actions">
<input class="button" type="submit" value="Download CSV" name="cmdDownload">
</div>
<table id="all_conversations_lists" cellspacing="0" width=100% class="wp-list-table widefat ">
	<thead>
		<tr>
			<th width=5% style="text-align:center" class="manage-column column-username sortable desc" scope="col"><input type="checkbox" name="cb_all" /></th>
			<th width=10% style="text-align:left" class="manage-column column-username sortable desc" id="username" scope="col">
                <span>
                    <?php
                     $n_sortorder = "asc";
                     if($_REQUEST['sortby'] == "wcu.full_name" && $_REQUEST['sortorder'] == "asc"){
                         $n_sortorder = "desc";
                     }
                    ?>
                <a href="?page=conversations&action=add&s_category_id=<?php echo $_REQUEST['s_category_id']?>&s_full_name=<?php echo $_REQUEST['s_full_name']?>&paging=<?php echo $_REQUEST['paging']?>&sortby=wcu.full_name&sortorder=<?=$n_sortorder?>">Full Name</a>
                </span>
            </th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Territory</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Role</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Activity Type</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Conversation</span></th>
			<th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Outcome</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Result</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Started</span></th>
            <th width=10% style="text-align:center" class="manage-column column-name sortable desc" id="name" scope="col"><span>Ended</span></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
            <th></th> <th></th> <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
		</tr>
	</tfoot>

	<tbody class="list:user" id="the-list">
    <?php
        $items = $conversation_items;
		if(!empty($items)){
			foreach($items as $item) {
		?>
			<tr >
				 <td style="text-align:center" class="input_name">
                    <input class="cb_item" type="checkbox" name="cb_item[]" value="<?php echo $item['id']; ?>" />
                    <input type="hidden" name="list_ordering_ids[]" value="<?php echo $item['id']; ?>">
				</td>
				 <td  style="text-align:left" class="input_name full-name">
					<?php echo $item['full_name']; ?>
				</td>
                <td style="text-align:center" class="input_name">
                    <?php echo $item['territory']; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo $item['role']; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo
                    $item['activity'];

                    ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo (isset($arrCategory[$item['category_id']]))?$arrCategory[$item['category_id']]:''; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo (isset($arrOutcome[$item['outcome_id']]))?$arrOutcome[$item['outcome_id']]:''; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo (isset($arrResults[$item['end_result']]))?$arrResults[$item['end_result']]:''; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo $item['started']; ?>
                </td>
                <td style="text-align:center" class="input_name">
                    <?php echo ($item['ended'] !="0000-00-00 00:00:00")?$item['ended']:''; ?>
                </td>
			</tr>

		<?php } ?>
            <tr>
				 <td colspan="8" class="check" scope="row" style="margin: 4px;"><?php echo $p->show(); ?></td>
			</tr>
		<?php }else{ ?>
			<tr>
				 <td colspan="8" class="check" scope="row" style="margin: 4px;">No conversation available</td>
			</tr>
		<?php }
	?>
	</tbody>
</table>
</form>