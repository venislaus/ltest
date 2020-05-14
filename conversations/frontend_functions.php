<?php
function fConversationDetailUrl($model_name,$model_id){
    global $wpdb;
    $url = site_url()."/conversation-detail/?".str_replace(" ","-",$model_name)."/".$model_id;
    return $url;
}
function conversation_user_form(){
    global $wpdb, $table_conversations,$table_conversation_territory,$table_conversation_role,$table_conversation_activity;
    if(isset($_COOKIE['cUserId']) && !empty($_COOKIE['cUserId']))
    {
       echo '<script>window.location = "'.site_url().'/conversation"</script>';
       exit;
    }
    ob_start();
    include('conversation_user_form.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}

function conversation_form(){
    global $wpdb, $table_conversations,$table_conversation_category;
    if(!$_COOKIE['cUserId'])
    {
        echo '<script>window.location = "'.site_url().'"</script>';
        exit;
    }
    if(isset($_POST['userKey']) && !empty($_POST['userKey']) && isset($_POST['cId']) && !empty($_POST['cId'])){
        $sql = "SELECT * FROM ".$table_conversations."
            WHERE
            user_key='".$_POST['userKey']."' AND
            category_id ='".$_POST['cId']."' AND
            started_at ='0000-00-00 00:00:00'";
        $conversations_items = $wpdb->get_results($sql, ARRAY_A);

        if(count($conversations_items) < 1){
            $table_data = array();
            $table_data['category_id'] = $_POST['cId'];
            $table_data['user_id'] = $_COOKIE['cUserId'];
            $table_data['user_key'] = $_POST['userKey'];
            $table_data['started_at'] = date("Y-m-d G:i:s");

            $sql = insert_table_sql($table_conversations, $table_data);
            $wpdb->query($sql);
            $conversation_id = $wpdb->insert_id;
            echo '<script>window.location = "'.site_url().'/outcome/?tId='.$conversation_id.'"</script>';
            exit;
        }
    }
    ob_start();
    include('conversation_form.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}

function conversation_outcome(){
    global $wpdb, $table_conversations, $table_conversation_outcome;
    if(!$_COOKIE['cUserId'])
    {
        echo '<script>window.location = "'.site_url().'"</script>';
        exit;
    }
    if(!$_GET['tId']){
        echo '<script>window.location = "'.site_url().'/conversation"</script>';
        exit;
    }
    $conversation_id = $_GET['tId'];
    $sql = "SELECT * FROM ".$table_conversations."
            WHERE
            id='".$conversation_id."' AND
            ended_at ='0000-00-00 00:00:00'";
    $conversations_items = $wpdb->get_results($sql, ARRAY_A);

    if(count($conversations_items) < 1){
        echo '<script>window.location = "'.site_url().'/conversation"</script>';
        exit;
    }
    ob_start();
    include('conversation_outcome.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}

function conversation_endresult(){
    global $wpdb, $table_conversations;
    if(!$_COOKIE['cUserId'])
    {
        echo '<script>window.location = "'.site_url().'"</script>';
        exit;
    }
    $conversation_id = $_POST['trackerId'];

    $sql = "SELECT * FROM ".$table_conversations."
            WHERE
            id='".$conversation_id."' AND
            ended_at ='0000-00-00 00:00:00'";
    $conversations_items = $wpdb->get_results($sql, ARRAY_A);

    if(count($conversations_items) > 0){
        $table_data = array();
        $table_data['outcome_id'] = $_POST['outcome_id'];

        $update_where['id'] = $conversation_id;
        $sql = update_table_sql($table_conversations, $table_data, $update_where);
        $wpdb->query($sql);
    }else{
        echo '<script>window.location = "'.site_url().'/conversation"</script>';
        exit;
    }
    ob_start();
    include('conversation_endresult.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}

function conversation_success(){
    global $wpdb, $table_conversations;
    if(!$_COOKIE['cUserId'])
    {
        echo '<script>window.location = "'.site_url().'"</script>';
        exit;
    }
    $conversation_id = $_POST['trackerId'];
    $sql = "SELECT * FROM ".$table_conversations."
            WHERE
            id='".$conversation_id."' AND
            ended_at ='0000-00-00 00:00:00'";
    $conversations_items = $wpdb->get_results($sql, ARRAY_A);

    if(count($conversations_items) > 0){
        $table_data = array();
        $table_data['end_result'] = $_POST['endresult_id'];
        $table_data['ended_at'] = date("Y-m-d G:i:s");

        $update_where['id'] = $conversation_id;
        $sql = update_table_sql($table_conversations, $table_data, $update_where);
        $wpdb->query($sql);
    }else{
        echo '<script>window.location = "'.site_url().'/conversation"</script>';
        exit;
    }
    ob_start();
    include('conversation_success.php');
    $output = ob_get_contents(); ob_end_clean();
    return $output;
}