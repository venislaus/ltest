<?php
/*
Plugin Name: Locations Plugin
Description: To display the locations
Author: Locations
Author URI: https://virtuous-studio.com/
Version: 1.3.1
*/

require_once('location_config.php');
require_once('general_functions.php');

add_action('admin_menu', 'locations_admin_menu');

// make ajaxurl available for front end too
add_action('wp_head','location_ajaxurl');
function location_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php }

// since we use init (and not admin_init) these scripts will loaded for both admin and front end pages of the plugin
add_action('init', 'load_locations_scripts');

function load_locations_scripts(){
    // register custom styles for this plugin
    //wp_register_style('locations-styles', plugins_url().'/locations/css/styles.css');

    // loading styles for this plugin
    wp_enqueue_style('locations-styles');

    // loading the required scripts that are already registered by wordpress core
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-autocomplete');
}


function locations_admin_menu() {
    global $current_user, $wpdb, $table_locations;

    if ( is_user_logged_in() ){
        if($current_user->roles[0] == "administrator"){
            $allowed_group = 'manage_options';
            add_menu_page(__('Locations','Locations'), __("Locations",'locations'), $allowed_group, 'locations', 'manage_locations_settings');
        }
    }
}

function manage_locations_settings(){
    global $wpdb, $locations_images_basepath, $table_locations,$table_location_category;
    // delete records
    if(isset($_POST['action']) && $_POST['action']=="delete" && isset($_POST['cb_item'])) {
        $delete_items = implode(",", $_POST['cb_item']);
        $sql = "DELETE FROM ".$table_locations." WHERE id in (".$delete_items.")";
        $wpdb->query($sql);
        if($wpdb->rows_affected>0){
            $result_message = "Successfully Deleted.";
        }
        else{
            $result_message = "No record found/Delete failed.";
        }
    }
    // form submit
    if(isset($_POST['save_locations'])){

        // get fields for db table
        $table_data = array();
        $table_data['location_name'] = $_POST['location_name'];
        $table_data['location_timings'] = $_POST['location_timings'];
        $table_data['phone'] = $_POST['phone'];

        if($_POST['save_locations'] == "Save"){
            // insert data
            // validate form
            $form_status = validate_location_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                $table_data['created_at'] = date("Y-m-d G:i:s");

                $sql = insert_table_sql($table_locations, $table_data);
                //echo $sql;
                //exit;
                $wpdb->query($sql);
                $location_id = $wpdb->insert_id;

                $result_message = "Successfully Added";
                unset($_POST);
            }
        }
        else{
            // update data

            // unset non existent fields for db table
            unset($table_data['location_id']);

            // validate form
            $form_status = validate_location_form();

            if($form_status['form_ok']===FALSE){
                echo $form_status['error_msg'];
            }
            else{
                unset($table_data['created_at']);

                // update record
                $update_where['id'] = $_POST['location_id'];
                $sql = update_table_sql($table_locations, $table_data, $update_where);
                $wpdb->query($sql);
                $location_id = $_POST['location_id'];
                $result_message = "Successfully Updated";
            }
        }
    }
    //search - start
    $where_sql = "";
    $prev_col = 0;
    $order_by = '';
    $custom_orderby = '';

    $s_location_name='';

    if(!empty($_REQUEST['s_location_name'])){
        $s_location_name = $_REQUEST['s_location_name'];
        $where_sql .= ($prev_col==1)? " AND " : "";
        $where_sql .= " location_name LIKE'%".$_REQUEST['s_location_name']."%' ";
        $prev_col = 1;
    }
    $s = "id";
    $t = "asc";
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
    // get location items
    $sql = "SELECT * FROM ".$table_locations." ".$where_sql." ".$order_by." ".$limit;
    $location_items = $wpdb->get_results($sql, ARRAY_A);

    // edit record
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['location_id'])) {

        // To get edit record
        $sql="SELECT * FROM ". $table_locations ." WHERE id = ".$_REQUEST['location_id']." ";
        $edit_data = $wpdb->get_results($sql, ARRAY_A);

        if(empty($edit_data)){
            $result_message = "No record found.";
        }else{
            $edit_rec = $edit_data[0];
        }
    }

    if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && isset($_REQUEST['location_id'])){
        require_once("location_edit.php");
    }elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
        require_once("location_add.php");
    }else{
        require_once("location_list.php");
    }
    $result_message = "";
}

function validate_location_form($data=array()){
    $return_data['form_ok'] = TRUE;
    $return_data['error_msg'] = "";

    if($_POST['location_name'] == ""){
        $return_data['form_ok'] = FALSE;
        $return_data['error_msg'] .= '<div class="error wppb-alert clear_both">Location name is required.</div>';
    }
    return $return_data;
}

function location_details(){
    global $wpdb,$wp, $table_locations;
    ob_start();
    include('location_details.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}

///////////////////////////////////////////////////////////////////////
// Related to plugin settings page

function locations_install(){
    global $wpdb;
    $table_locations = $wpdb->prefix . "locations";

    $sql = "DROP TABLE IF EXISTS ". $table_locations .";

    CREATE TABLE ".$table_locations." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(250) NOT NULL,
  `location_timings` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function locations_uninstall() {
    global $wpdb;
    $table_locations = $wpdb->prefix . "locations";

    $sql = "DROP TABLE ". $table_locations ."; ";
    $wpdb->query($sql);
}

if ( ! function_exists( 'disable_secure_logged_in_cookie' ) ) {
    function disable_secure_logged_in_cookie() {
        return FALSE;
    }
    add_filter( 'secure_logged_in_cookie', 'disable_secure_logged_in_cookie' );
}
register_activation_hook( __FILE__, 'locations_install' );
register_deactivation_hook( __FILE__, 'locations_uninstall' );

add_shortcode('location_details', 'location_details');