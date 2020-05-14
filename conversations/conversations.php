<?php
/*
Plugin Name: Conversation Tracker
Description: Conversation tracker
Author: Venis
Author URI: https://venislas.com/
Version: 1.0.0
*/

require_once('conversation_config.php');
require_once('general_functions.php');
require_once('paginationconversation.class.php');

add_action('admin_menu', 'conversations_admin_menu');

// make ajaxurl available for front end too
add_action('wp_head','conversation_ajaxurl');
function conversation_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php }

// since we use init (and not admin_init) these scripts will loaded for both admin and front end pages of the plugin
add_action('init', 'load_conversations_scripts');

function load_conversations_scripts(){
    // register custom styles for this plugin
    wp_register_style('conversations-styles', plugins_url().'/conversations/css/styles.css');

    // loading styles for this plugin
    wp_enqueue_style('conversations-styles');

    // loading the required scripts that are already registered by wordpress core
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-autocomplete');
}


function conversations_admin_menu() {
    global $current_user;

    if ( is_user_logged_in() ){
        if($current_user->roles[0] == "administrator"){
            $allowed_group = 'manage_options';
            add_menu_page(__('Conversations Tracker','Conversations Tracker'), __("Conversations Tracker",'conversations'), $allowed_group, 'conversations', 'manage_conversations_settings');
            add_submenu_page("conversations", "Category", "Category", 0, "conversation_category", "manage_conversation_category_settings");
            add_submenu_page("conversations", "Outcome", "Outcome", 0, "conversation_outcome", "manage_conversation_outcome_settings");
            add_submenu_page("conversations", "Territory", "Territory", 0, "conversation_territory", "manage_conversation_territory_settings");
            add_submenu_page("conversations", "Role", "Role", 0, "conversation_role", "manage_conversation_role_settings");
            add_submenu_page("conversations", "Activity", "Activity", 0, "conversation_activity", "manage_conversation_activity_settings");
        }
    }
}

function manage_conversations_settings(){
    global $wpdb, $conversations_images_basepath, $table_conversations,$table_conversation_category,$table_conversation_territory,$table_conversation_outcome,$table_conversation_users,$table_conversation_role,$table_conversation_activity;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversations." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);

        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //search - start
    $where_sql = "wc.user_id = wcu.id";
    $prev_col = 1;
    $order_by = '';
    $custom_orderby = '';
    $group_by = 'group by wc.id';

    $s_category_id=$s_tag_id=$s_full_name='';

    if(!empty($_REQUEST['s_category_id'])){
        $s_category_id = $_REQUEST['s_category_id'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " category_id ='".$_REQUEST['s_category_id']."' ";
        $prev_col = 1;
    }
    if(!empty($_REQUEST['s_full_name'])){
        $s_full_name = $_REQUEST['s_full_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " full_name LIKE'%".$_REQUEST['s_full_name']."%' ";
        $prev_col = 1;
    }
    $s = "wc.id";
    $t = "desc";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    // get the number of images items
   $sql = "select sum(totalcount) conversation_count from( SELECT count(*) AS totalcount FROM ".$table_conversations." wc, ".$table_conversation_users." wcu ".$where_sql." ".$group_by." ".$order_by.") as s";
    //, ".$table_conversation_category." wcc, ".$table_conversation_outcome." wco,
    $conversation_count = $wpdb->get_results($sql, ARRAY_A);

    if($conversation_count[0]['conversation_count'] > 0) {
        $p = new pagination_conversation;
        $p->items($conversation_count[0]['conversation_count']);
        $p->limit(10); // Limit entries per page
        $p->target("admin.php?page=conversations&s_category_id=".$s_category_id."&s_full_name=".$s_full_name."&sortby=".$s."&sortorder=".$t);
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page

        if(!isset($_GET['paging']) || empty($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
    } else {
        //"No Record Found";
        $limit = "";
    }
    //$limit = "";
    // get conversation items
    $sql = "SELECT
	wc.id as idu,
	wc.category_id,
	wc.outcome_id,
	wc.end_result,
	wc.started_at as started,
	wc.ended_at as ended,
    wcu.full_name as full_name,
    wcr.role_name as role,
    IF(wcu.activity_id = '999999999', other_activity,wca.activity_name) as activity,
    wct.territory_name as territory
FROM ".$table_conversations." wc,".$table_conversation_users." wcu
LEFT JOIN ".$table_conversation_role." wcr
ON wcu.role_id = wcr.id
LEFT JOIN ".$table_conversation_activity." wca
ON wcu.activity_id = wca.id
LEFT JOIN ".$table_conversation_territory." wct
ON wcu.territory_id = wct.id
".$where_sql." ".$group_by." ".$order_by." ".$limit;

$conversation_items = $wpdb->get_results($sql, ARRAY_A);

    $arrCategory = $arrOutcome = array();
    $sql = "SELECT * FROM ".$table_conversation_category;
    $conversation_category_items = $wpdb->get_results($sql, ARRAY_A);
    foreach($conversation_category_items as $category) $arrCategory[$category['id']] = $category['category_name'];

    $sql = "SELECT * FROM ".$table_conversation_outcome;
    $conversation_outcome_items = $wpdb->get_results($sql, ARRAY_A);
    foreach($conversation_outcome_items as $outcome) $arrOutcome[$outcome['id']] = $outcome['outcome_name'];

    $arrResults = array(1=>"Positive",2=>"Indifferent",3=>"Negative");

    require_once("conversation_list.php");

    $result_message = "";
}

function manage_conversation_category_settings(){
    global $wpdb, $table_conversation_category,$conversations_images_basepath,$conversations_images_baseurl;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversation_category." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        // delete the images of the records
        foreach($_POST['cb_item'] as $cat_id){
            // delete the full size images
            $target_path = $conversations_images_basepath."/category/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }

            // delete the thumbnails
            $target_path = $target_path = $conversations_images_basepath."/category/thumbsize1/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }

            // delete the thumbnails
            $target_path = $target_path = $conversations_images_basepath."/category/thumbsize2/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }
        }
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //Update Ordering
    if(isset($_POST['update_category_ordering'])) {
        $count_list_ordering_ids = sizeof($_POST['list_ordering_ids']);
        for($i=0;$i<$count_list_ordering_ids;$i++){
            $ordering = ($i+1);
            if(!empty($_POST['list_ordering_ids'][$i])){
                $table_data = array();
                $table_data['ordering'] = ($i+1);
                $update_where['id'] =  $_POST['list_ordering_ids'][$i];
                $sql = update_table_sql($table_conversation_category, $table_data, $update_where);
                $wpdb->query($sql);
            }
        }
        $result_message = "Updated Successfully.";
    }
    // form submit
    if(isset($_POST['save_category_list'])){
        // get fields for db table
        $table_data = $_POST;

        // unset non existent fields for db table
        unset($table_data['save_category_list']);

        if($_POST['save_category_list'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_conversation_category_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $category_image = sanitize_text_field($_FILES['category_image']['name']);
                $table_data['category_image'] = $category_image;

                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_conversation_category, $table_data);
                $wpdb->query($sql);
                $category_id = $wpdb->insert_id;
                // save the images in a dir named with the id of the course.
                if(!empty($_FILES['category_image']['name'])){
                    $image_param['category_id'] = $category_id;

                    $image_param['file']['error'] = $_FILES['category_image']['error'];
                    $image_param['file']['name'] = $_FILES['category_image']['name'];
                    $image_param['file']['tmp_name'] = $_FILES['category_image']['tmp_name'];
                    save_category_list($image_param);
                }
                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['category_id']);
            unset($table_data['hid_category_image']);

            // validate form
            $form_status = validate_conversation_category_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                if(!empty($_FILES['category_image']['name'])){
                    $category_image = sanitize_text_field($_FILES['category_image']['name']);
                }else{
                    $category_image = $_POST['hid_category_image'];
                }
                $table_data['category_image'] = $category_image;
                // update record
                $update_where['id'] = $_POST['category_id'];

                $sql = update_table_sql($table_conversation_category, $table_data, $update_where);
                $wpdb->query($sql);

                $category_id = $_POST['category_id'];
                if(!empty($_FILES['category_image']['name'])){
                    $image_param['category_id'] = $category_id;

                    $image_param['file']['error'] = $_FILES['category_image']['error'];
                    $image_param['file']['name'] = $_FILES['category_image']['name'];
                    $image_param['file']['tmp_name'] = $_FILES['category_image']['tmp_name'];
                    save_category_list($image_param);
                }

                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';
    $s_category_name='';

    if(!empty($_REQUEST['s_category_name'])){
        $s_category_name = $_REQUEST['s_category_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " category_name LIKE'%".$_REQUEST['s_category_name']."%' ";
        $prev_col = 1;
    }
    $s = "ordering";
    $t = "ASC";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    $limit = "";
    // get category items
    $sql = "SELECT * FROM ".$table_conversation_category." ".$where_sql." ".$order_by." ".$limit;
    $conversation_category_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['category_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_conversation_category ." WHERE id = ".$_REQUEST['category_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['category_id'])){
        require_once("category_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("category_add.php");
    }else{
        require_once("category_list.php");
    }
}

function manage_conversation_outcome_settings(){
    global $wpdb, $table_conversation_outcome,$conversations_images_basepath,$conversations_images_baseurl;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversation_outcome." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        // delete the images of the records
        foreach($_POST['cb_item'] as $cat_id){
            // delete the full size images
            $target_path = $conversations_images_basepath."/outcome/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }

            // delete the thumbnails
            $target_path = $target_path = $conversations_images_basepath."/outcome/thumbsize1/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }

            // delete the thumbnails
            $target_path = $target_path = $conversations_images_basepath."/outcome/thumbsize2/".$cat_id;
            if(file_exists($target_path) || is_dir($target_path)){
                rmdirr($target_path);
            }
        }
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //Update Ordering
    if(isset($_POST['update_outcome_ordering'])) {
        $count_list_ordering_ids = sizeof($_POST['list_ordering_ids']);
        for($i=0;$i<$count_list_ordering_ids;$i++){
            $ordering = ($i+1);
            if(!empty($_POST['list_ordering_ids'][$i])){
                $table_data = array();
                $table_data['ordering'] = ($i+1);
                $update_where['id'] =  $_POST['list_ordering_ids'][$i];
                $sql = update_table_sql($table_conversation_outcome, $table_data, $update_where);
                $wpdb->query($sql);
            }
        }
        $result_message = "Updated Successfully.";
    }
    // form submit
    if(isset($_POST['save_outcome_list'])){
        // get fields for db table
        $table_data = $_POST;

        // unset non existent fields for db table
        unset($table_data['save_outcome_list']);

        if($_POST['save_outcome_list'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_conversation_outcome_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $outcome_image = sanitize_text_field($_FILES['outcome_image']['name']);
                $table_data['outcome_image'] = $outcome_image;
                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_conversation_outcome, $table_data);
                $wpdb->query($sql);
                $outcome_id = $wpdb->insert_id;
                // save the images in a dir named with the id of the course.
                if(!empty($_FILES['outcome_image']['name'])){
                    $image_param['outcome_id'] = $outcome_id;

                    $image_param['file']['error'] = $_FILES['outcome_image']['error'];
                    $image_param['file']['name'] = $_FILES['outcome_image']['name'];
                    $image_param['file']['tmp_name'] = $_FILES['outcome_image']['tmp_name'];
                    save_outcome_list($image_param);
                }
                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['outcome_id']);
            unset($table_data['hid_outcome_image']);

            // validate form
            $form_status = validate_conversation_outcome_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                if(!empty($_FILES['outcome_image']['name'])){
                    $outcome_image = sanitize_text_field($_FILES['outcome_image']['name']);
                }else{
                    $outcome_image = $_POST['hid_outcome_image'];
                }
                $table_data['outcome_image'] = $outcome_image;
                // update record
                $update_where['id'] = $_POST['outcome_id'];

                $sql = update_table_sql($table_conversation_outcome, $table_data, $update_where);
                $wpdb->query($sql);

                $outcome_id = $_POST['outcome_id'];
                if(!empty($_FILES['outcome_image']['name'])){
                    $image_param['outcome_id'] = $outcome_id;

                    $image_param['file']['error'] = $_FILES['outcome_image']['error'];
                    $image_param['file']['name'] = $_FILES['outcome_image']['name'];
                    $image_param['file']['tmp_name'] = $_FILES['outcome_image']['tmp_name'];
                    save_outcome_list($image_param);
                }

                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';
    $s_outcome_name='';

    if(!empty($_REQUEST['s_outcome_name'])){
        $s_outcome_name = $_REQUEST['s_outcome_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " outcome_name LIKE'%".$_REQUEST['s_outcome_name']."%' ";
        $prev_col = 1;
    }
    $s = "ordering";
    $t = "ASC";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    $limit = "";
    // get outcome items
    $sql = "SELECT * FROM ".$table_conversation_outcome." ".$where_sql." ".$order_by." ".$limit;
    $conversation_outcome_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['outcome_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_conversation_outcome ." WHERE id = ".$_REQUEST['outcome_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['outcome_id'])){
        require_once("outcome_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("outcome_add.php");
    }else{
        require_once("outcome_list.php");
    }
}

function manage_conversation_territory_settings(){
    global $wpdb, $table_conversation_territory;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversation_territory." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //Update Ordering
    if(isset($_POST['update_territory_ordering'])) {
        $count_list_ordering_ids = sizeof($_POST['list_ordering_ids']);
        for($i=0;$i<$count_list_ordering_ids;$i++){
            $ordering = ($i+1);
            if(!empty($_POST['list_ordering_ids'][$i])){
                $table_data = array();
                $table_data['ordering'] = ($i+1);
                $update_where['id'] =  $_POST['list_ordering_ids'][$i];
                $sql = update_table_sql($table_conversation_territory, $table_data, $update_where);
                $wpdb->query($sql);
            }
        }
        $result_message = "Updated Successfully.";
    }
    // form submit
    if(isset($_POST['save_territory_list'])){
        // get fields for db table
        $table_data = $_POST;

        // unset non existent fields for db table
        unset($table_data['save_territory_list']);

        if($_POST['save_territory_list'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_conversation_territory_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_conversation_territory, $table_data);
                $wpdb->query($sql);

                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['territory_id']);

            // validate form
            $form_status = validate_conversation_territory_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                // update record
                $update_where['id'] = $_POST['territory_id'];

                $sql = update_table_sql($table_conversation_territory, $table_data, $update_where);
                $wpdb->query($sql);

                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';
    $s_territory_name='';

    if(!empty($_REQUEST['s_territory_name'])){
        $s_territory_name = $_REQUEST['s_territory_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " territory_name LIKE'%".$_REQUEST['s_territory_name']."%' ";
        $prev_col = 1;
    }
    $s = "ordering";
    $t = "ASC";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    // get the number of images items
    $sql = "SELECT count(id) AS territory_count FROM ".$table_conversation_territory." ".$where_sql." ".$order_by;
    $territory_count = $wpdb->get_results($sql, ARRAY_A);

    if($territory_count[0]['territory_count'] > 0) {
        $p = new pagination_conversation;
        $p->items($territory_count[0]['territory_count']);
        $p->limit(100); // Limit entries per page
        $p->target("admin.php?page=conversation_territory&s_territory_name=".$s_territory_name."&sortby=".$s."&sortorder=".$t);
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page

        if(!isset($_GET['paging']) || empty($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
    } else {
        //"No Record Found";
        $limit = "";
    }
    //$limit = "";
    // get territory items
    $sql = "SELECT * FROM ".$table_conversation_territory." ".$where_sql." ".$order_by." ".$limit;
    $conversation_territory_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['territory_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_conversation_territory ." WHERE id = ".$_REQUEST['territory_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['territory_id'])){
        require_once("territory_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("territory_add.php");
    }else{
        require_once("territory_list.php");
    }
}

function manage_conversation_role_settings(){
    global $wpdb, $table_conversation_role;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversation_role." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //Update Ordering
    if(isset($_POST['update_role_ordering'])) {
        $count_list_ordering_ids = sizeof($_POST['list_ordering_ids']);
        for($i=0;$i<$count_list_ordering_ids;$i++){
            $ordering = ($i+1);
            if(!empty($_POST['list_ordering_ids'][$i])){
                $table_data = array();
                $table_data['ordering'] = ($i+1);
                $update_where['id'] =  $_POST['list_ordering_ids'][$i];
                $sql = update_table_sql($table_conversation_role, $table_data, $update_where);
                $wpdb->query($sql);
            }
        }
        $result_message = "Updated Successfully.";
    }
    // form submit
    if(isset($_POST['save_role_list'])){
        // get fields for db table
        $table_data = $_POST;

        // unset non existent fields for db table
        unset($table_data['save_role_list']);

        if($_POST['save_role_list'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_conversation_role_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_conversation_role, $table_data);
                $wpdb->query($sql);

                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['role_id']);

            // validate form
            $form_status = validate_conversation_role_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                // update record
                $update_where['id'] = $_POST['role_id'];

                $sql = update_table_sql($table_conversation_role, $table_data, $update_where);
                $wpdb->query($sql);

                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';
    $s_role_name='';

    if(!empty($_REQUEST['s_role_name'])){
        $s_role_name = $_REQUEST['s_role_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " role_name LIKE'%".$_REQUEST['s_role_name']."%' ";
        $prev_col = 1;
    }
    $s = "ordering";
    $t = "ASC";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    // get the number of images items
    $sql = "SELECT count(id) AS role_count FROM ".$table_conversation_role." ".$where_sql." ".$order_by;
    $role_count = $wpdb->get_results($sql, ARRAY_A);

    if($role_count[0]['role_count'] > 0) {
        $p = new pagination_conversation;
        $p->items($role_count[0]['role_count']);
        $p->limit(100); // Limit entries per page
        $p->target("admin.php?page=conversation_role&s_role_name=".$s_role_name."&sortby=".$s."&sortorder=".$t);
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page

        if(!isset($_GET['paging']) || empty($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
    } else {
        //"No Record Found";
        $limit = "";
    }
    //$limit = "";
    // get role items
    $sql = "SELECT * FROM ".$table_conversation_role." ".$where_sql." ".$order_by." ".$limit;
    $conversation_role_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['role_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_conversation_role ." WHERE id = ".$_REQUEST['role_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['role_id'])){
        require_once("role_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("role_add.php");
    }else{
        require_once("role_list.php");
    }
}

function manage_conversation_activity_settings(){
    global $wpdb, $table_conversation_activity;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_conversation_activity." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    //Update Ordering
    if(isset($_POST['update_activity_ordering'])) {
        $count_list_ordering_ids = sizeof($_POST['list_ordering_ids']);
        for($i=0;$i<$count_list_ordering_ids;$i++){
            $ordering = ($i+1);
            if(!empty($_POST['list_ordering_ids'][$i])){
                $table_data = array();
                $table_data['ordering'] = ($i+1);
                $update_where['id'] =  $_POST['list_ordering_ids'][$i];
                $sql = update_table_sql($table_conversation_activity, $table_data, $update_where);
                $wpdb->query($sql);
            }
        }
        $result_message = "Updated Successfully.";
    }
    // form submit
    if(isset($_POST['save_activity_list'])){
        // get fields for db table
        $table_data = $_POST;

        // unset non existent fields for db table
        unset($table_data['save_activity_list']);

        if($_POST['save_activity_list'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_conversation_activity_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_conversation_activity, $table_data);
                $wpdb->query($sql);

                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['activity_id']);

            // validate form
            $form_status = validate_conversation_activity_list_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                // update record
                $update_where['id'] = $_POST['activity_id'];

                $sql = update_table_sql($table_conversation_activity, $table_data, $update_where);
                $wpdb->query($sql);

                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';
    $s_activity_name='';

    if(!empty($_REQUEST['s_activity_name'])){
        $s_activity_name = $_REQUEST['s_activity_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " activity_name LIKE'%".$_REQUEST['s_activity_name']."%' ";
        $prev_col = 1;
    }
    $s = "ordering";
    $t = "ASC";
    if(!empty($_REQUEST['sortby'])){
        $s = $_REQUEST['sortby'];
    }
    if(!empty($_REQUEST['sortby'])){
        $t = $_REQUEST['sortorder'];
    }
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";
    //search - end

    // get the number of images items
    $sql = "SELECT count(id) AS activity_count FROM ".$table_conversation_activity." ".$where_sql." ".$order_by;
    $activity_count = $wpdb->get_results($sql, ARRAY_A);

    if($activity_count[0]['activity_count'] > 0) {
        $p = new pagination_conversation;
        $p->items($activity_count[0]['activity_count']);
        $p->limit(100); // Limit entries per page
        $p->target("admin.php?page=conversation_activity&s_activity_name=".$s_activity_name."&sortby=".$s."&sortorder=".$t);
        $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
        $p->calculate(); // Calculates what to show
        $p->parameterName('paging');
        $p->adjacents(1); //No. of page away from the current page

        if(!isset($_GET['paging']) || empty($_GET['paging'])) {
            $p->page = 1;
        } else {
            $p->page = $_GET['paging'];
        }
        //Query for limit paging
        $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
    } else {
        //"No Record Found";
        $limit = "";
    }
    //$limit = "";
    // get activity items
    $sql = "SELECT * FROM ".$table_conversation_activity." ".$where_sql." ".$order_by." ".$limit;
    $conversation_activity_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['activity_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_conversation_activity ." WHERE id = ".$_REQUEST['activity_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['activity_id'])){
        require_once("activity_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("activity_add.php");
    }else{
        require_once("activity_list.php");
    }
}

function save_category_list($param=array()){
    global $wpdb;
    include_once("class.pThumb.php");

    if(($param["file"]["error"] == 0)){
        $image_name = sanitize_text_field($param["file"]['name']);
        $upload_image = $param["file"]["tmp_name"];

        $target_path = ABSPATH."wp-content/plugins/conversations/images/category";

        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        // save in original size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/category/".$param["category_id"];

        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);

        $target_path = ABSPATH."wp-content/plugins/conversations/images/category/thumbsize1/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $target_path = ABSPATH."wp-content/plugins/conversations/images/category/thumbsize2/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }

        // save in 890x540 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/category/thumbsize1/".$param["category_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(100, 100);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);

        // save in 150x150 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/category/thumbsize2/".$param["category_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(50, 50);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);
    }
}
function save_outcome_list($param=array()){
    global $wpdb;
    include_once("class.pThumb.php");

    if(($param["file"]["error"] == 0)){
        $image_name = sanitize_text_field($param["file"]['name']);
        $upload_image = $param["file"]["tmp_name"];

        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome";

        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        // save in original size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome/".$param["outcome_id"];

        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);

        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome/thumbsize1/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome/thumbsize2/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }

        // save in 890x540 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome/thumbsize1/".$param["outcome_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(100, 100);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);

        // save in 150x150 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/outcome/thumbsize2/".$param["outcome_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(50, 50);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);
    }
}
function save_conversations_image($param=array()){
    global $wpdb;
    include_once("class.pThumb.php");

    if(($param["file"]["error"] == 0)){
        $image_name = sanitize_text_field($param["file"]['name']);
        $upload_image = $param["file"]["tmp_name"];

        // save in original size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/conversations/".$param["conversation_id"];

        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);

        $target_path = ABSPATH."wp-content/plugins/conversations/images/conversations/thumbsize1/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $target_path = ABSPATH."wp-content/plugins/conversations/images/conversations/thumbsize2/";
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        // save in 250x250 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/conversations/thumbsize1/".$param["conversation_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(525, 350);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);

        // save in 150x150 size
        $target_path = ABSPATH."wp-content/plugins/conversations/images/conversations/thumbsize2/".$param["conversation_id"];
        if(!file_exists($target_path) || !is_dir($target_path)){
            mkdir($target_path,0777);
        }
        $newimage = $target_path."/".$image_name;
        copy($upload_image, $newimage);
        $img=new pThumb();
        $img->pSetSize(300, 170);
        $img->pSetQuality(100);
        $img->pCreate($newimage);
        $img->pSave($newimage);
    }
}

function validate_conversation_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['conversations_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error wppb-alert clear_both">Name is required.</div>';
    }
    if(empty($_POST['category_id'])){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error wppb-alert clear_both">Category is required.</div>';
    }
    return $return_data;
}
function validate_conversation_category_list_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['category_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error clear_both">Category Name is required.</div>';
    }
    return $return_data;
}

function validate_conversation_outcome_list_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['outcome_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error clear_both">Outcome Name is required.</div>';
    }
    return $return_data;
}

function validate_conversation_territory_list_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['territory_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error clear_both">Territory Name is required.</div>';
    }
    return $return_data;
}
function validate_conversation_role_list_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['role_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error clear_both">Role Name is required.</div>';
    }
    return $return_data;
}

function validate_conversation_activity_list_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['activity_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error clear_both">Activity Type is required.</div>';
    }
    return $return_data;
}
///////////////////////////////////////////////////////////////////////
// Related to plugin settings page
function conversations_install(){
    global $wpdb;
    $table_conversations = $wpdb->prefix . "conversations";

    $sql = "DROP TABLE IF EXISTS ". $table_conversations .";

    CREATE TABLE ".$table_conversations." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `outcome_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_key` varchar(100) NOT NULL,
  `end_result` int(3) NOT NULL,
  `started_at` datetime NOT NULL,
  `ended_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversations_uninstall() {
    global $wpdb;
    $table_conversations = $wpdb->prefix . "conversations";

    $sql = "DROP TABLE ". $table_conversations ."; ";
    $wpdb->query($sql);
}

function conversation_user_install(){
    global $wpdb;
    $table_conversation_users = $wpdb->prefix . "conversation_users";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_users .";

   CREATE TABLE ".$table_conversation_users." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `territory_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `other_activity` text NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_user_uninstall() {
    global $wpdb;
    $table_conversation_users = $wpdb->prefix . "conversation_users";

    $sql = "DROP TABLE ". $table_conversation_users ."; ";
    $wpdb->query($sql);
}

function conversation_category_install(){
    global $wpdb;
    $table_conversation_category = $wpdb->prefix . "conversation_category";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_category .";

    CREATE TABLE ".$table_conversation_category." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) NOT NULL,
  `category_image` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_category_uninstall() {
    global $wpdb;
    $table_conversation_category = $wpdb->prefix . "conversation_category";

    $sql = "DROP TABLE ". $table_conversation_category ."; ";
    $wpdb->query($sql);
}

function conversation_outcome_install(){
    global $wpdb;
    $table_conversation_outcome = $wpdb->prefix . "conversation_outcome";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_outcome .";

    CREATE TABLE ".$table_conversation_outcome." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `outcome_name` varchar(250) NOT NULL,
  `outcome_image` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_outcome_uninstall() {
    global $wpdb;
    $table_conversation_outcome = $wpdb->prefix . "conversation_outcome";

    $sql = "DROP TABLE ". $table_conversation_outcome ."; ";
    $wpdb->query($sql);
}

function conversation_territory_install(){
    global $wpdb;
    $table_conversation_territory = $wpdb->prefix . "conversation_territory";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_territory .";

    CREATE TABLE ".$table_conversation_territory." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `territory_name` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_territory_uninstall() {
    global $wpdb;
    $table_conversation_territory = $wpdb->prefix . "conversation_territory";

    $sql = "DROP TABLE ". $table_conversation_territory ."; ";
    $wpdb->query($sql);
}

function conversation_role_install(){
    global $wpdb;
    $table_conversation_role = $wpdb->prefix . "conversation_role";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_role .";

    CREATE TABLE ".$table_conversation_role." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_role_uninstall() {
    global $wpdb;
    $table_conversation_role = $wpdb->prefix . "conversation_role";

    $sql = "DROP TABLE ". $table_conversation_role ."; ";
    $wpdb->query($sql);
}
function conversation_activity_install(){
    global $wpdb;
    $table_conversation_activity = $wpdb->prefix . "conversation_activity";

    $sql = "DROP TABLE IF EXISTS ". $table_conversation_activity .";

    CREATE TABLE ".$table_conversation_activity." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(250) NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function conversation_activity_uninstall() {
    global $wpdb;
    $table_conversation_activity = $wpdb->prefix . "conversation_activity";

    $sql = "DROP TABLE ". $table_conversation_activity ."; ";
    $wpdb->query($sql);
}

require_once('frontend_functions.php');

if ( ! function_exists( 'disable_secure_logged_in_cookie' ) ) {
    function disable_secure_logged_in_cookie() {
        return FALSE;
    }
    add_filter( 'secure_logged_in_cookie', 'disable_secure_logged_in_cookie' );
}
register_activation_hook( __FILE__, 'conversations_install' );
register_deactivation_hook( __FILE__, 'conversations_uninstall' );

register_activation_hook( __FILE__, 'conversation_user_install' );
register_deactivation_hook( __FILE__, 'conversation_user_uninstall' );

register_activation_hook( __FILE__, 'conversation_category_install' );
register_deactivation_hook( __FILE__, 'conversation_category_uninstall' );

register_activation_hook( __FILE__, 'conversation_outcome_install' );
register_deactivation_hook( __FILE__, 'conversation_outcome_uninstall' );

register_activation_hook( __FILE__, 'conversation_territory_install' );
register_deactivation_hook( __FILE__, 'conversation_territory_uninstall' );

register_activation_hook( __FILE__, 'conversation_role_install' );
register_deactivation_hook( __FILE__, 'conversation_role_uninstall' );

register_activation_hook( __FILE__, 'conversation_activity_install' );
register_deactivation_hook( __FILE__, 'conversation_activity_uninstall' );


add_shortcode('conversation_user_form', 'conversation_user_form');
add_shortcode('conversation_form', 'conversation_form');
add_shortcode('conversation_outcome', 'conversation_outcome');
add_shortcode('conversation_endresult', 'conversation_endresult');
add_shortcode('conversation_success', 'conversation_success');

if(isset($_POST['cmdUserForm'])){
    add_action('init','set_user_cookie');
}

function set_user_cookie() {
    global $wpdb, $table_conversation_users;
    if (!isset($_COOKIE['cUserId'])) {

        $table_data = array();
        $table_data['role_id'] = $_POST['user_role'];
        $table_data['territory_id'] = $_POST['user_shopterritory'];
        $table_data['activity_id'] = $_POST['user_activity'];
        $table_data['other_activity'] = addslashes($_POST['user_otheractivity']);
        $table_data['full_name'] = $_POST['user_fullname'];
        $table_data['created_at'] = date("Y-m-d G:i:s");

        $sql = insert_table_sql($table_conversation_users, $table_data);
        $wpdb->query($sql);
        $user_id = $wpdb->insert_id;

        setcookie('cUserId', $user_id, time() + 86400);
        header("Location: ".site_url()."/conversation");
        exit;
    }
}
if(isset($_POST['cmdDownload'])){
    add_action('init','download_csv');
}

function download_csv() {
    global $wpdb, $table_conversations,$table_conversation_users,$table_conversation_category,$table_conversation_outcome,$table_conversation_territory,$table_conversation_users,$table_conversation_activity,$table_conversation_role;
    $where_sql = "wc.user_id = wcu.id";
    $group_by = 'group by wc.id';
    $s = "wc.id";
    $t = "desc";
    $order_by = ' ORDER BY '.$s.' '.$t;
    $where_sql = (trim($where_sql)!="")? " WHERE " . $where_sql : "";

    $sql = "SELECT
	wc.id as idu,
	wc.category_id,
	wc.outcome_id,
	wc.end_result,
	wc.started_at as started,
	wc.ended_at as ended,
    wcu.full_name as full_name,
    wcr.role_name as role,
    IF(wcu.activity_id = '999999999', other_activity,wca.activity_name) as activity,
    wct.territory_name as territory
FROM ".$table_conversations." wc,".$table_conversation_users." wcu
LEFT JOIN ".$table_conversation_role." wcr
ON wcu.role_id = wcr.id
LEFT JOIN ".$table_conversation_activity." wca
ON wcu.activity_id = wca.id
LEFT JOIN ".$table_conversation_territory." wct
ON wcu.territory_id = wct.id"
.$where_sql." ".$group_by." ".$order_by;
    $conversation_items = $wpdb->get_results($sql, ARRAY_A);

    $items = $conversation_items;

    $arrCategory = $arrOutcome = array();
    $sql = "SELECT * FROM ".$table_conversation_category;
    $conversation_category_items = $wpdb->get_results($sql, ARRAY_A);
    foreach($conversation_category_items as $category) $arrCategory[$category['id']] = $category['category_name'];

    $sql = "SELECT * FROM ".$table_conversation_outcome;
    $conversation_outcome_items = $wpdb->get_results($sql, ARRAY_A);
    foreach($conversation_outcome_items as $outcome) $arrOutcome[$outcome['id']] = $outcome['outcome_name'];

    if(!empty($items)){
        $arrResults = array(1=>"Positive",2=>"Indifferent",3=>"Negative");
        $titleArray = array("Full Name","Territory","Role","Activity Type","Conversation","Outcome","Result","Started","Ended");

        $filename="conversation.csv";

        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        fputcsv($fp, $titleArray);

        foreach($items as $item) {
            $category_name = (isset($arrCategory[$item['category_id']]))?$arrCategory[$item['category_id']]:'';
            $outcome_name = (isset($arrOutcome[$item['outcome_id']]))?$arrOutcome[$item['outcome_id']]:'';

            $result_name = (isset($arrResults[$item['end_result']]))?$arrResults[$item['end_result']]:'';

            $ended = ($item['ended'] !="0000-00-00 00:00:00")?$item['ended']:'';

            $data = array("Full Name"=>$item['full_name'],
                "Territory" => $item['territory'],
                "Role" => $item['role'],
                "Activity" => $item['activity'],
                "Conversation" => $category_name,
                "Outcome" => $outcome_name,
                "Result" => $result_name,
                "Started" => $item['started'],
                "Ended" => $ended,
            );
            fputcsv($fp, $data);
        }
    }
    exit;
}

function getConversationDetailById(){
    global $wpdb,$table_conversations;
    $urlString = '';
    foreach($_REQUEST as $key=>$val){
        $urlString .= str_replace("&","%26",$key);
    }
    unset($_REQUEST);
    $_REQUEST[$urlString] = $urlString;
    //print_r($_REQUEST);
    $gConversationId = array_keys($_REQUEST);
    $gConversationId = explode("/",$gConversationId[0]);
    $_GET['conversation_id'] = $gConversationId[2];

    // get conversation items
    $sql = "SELECT * FROM ".$table_conversations." WHERE id = '".$_GET['conversation_id']."' ";
    $conversation_detail = $wpdb->get_results($sql, ARRAY_A);
    return $conversation_detail;
}