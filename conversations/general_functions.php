<?php
// User defined functions that are relevant to any php/mysql application

// Create a mysql insert statement
if (!function_exists('insert_table_sql')){
    function insert_table_sql($table_name="", $insert_data=array()) 
    {
    	$sql = "";
    	$append = array();
    	foreach($insert_data as $key => $val ) {
    	    if($val=="")
    		$append[] = trim($key) . "=''";   
    	    else             
    		$append[] = trim($key) . "='" . trim($val) ."'";
    	}
    	return $sql = "INSERT INTO $table_name SET ".implode(",", $append);
    } 
}


// Create a mysql update statement
// $where: Pass either a array or string for where clause
if (!function_exists('update_table_sql')){
    function update_table_sql($table_name="", $update_data=array(), $where) 
    {
    	$sql = "";
    	$append = array();
    	foreach($update_data as $key => $val ) {
    	    if($val=="")
    		$append[] = trim($key) . "=''";   
    	    else             
    		$append[] = trim($key) . "='" . trim($val) ."'";
    	}
        
        $append_where = array();
        if(is_array($where)){
            foreach($where as $key => $val){
        	    if($val=="")
        		$append_where[] = trim($key) . "=''";   
        	    else             
        		$append_where[] = trim($key) . "='" . trim($val) ."'";
            } 
            
            $sql = "UPDATE $table_name SET ".implode(",", $append)." WHERE ";        
            $sql .= " ". implode(" AND ", $append_where) ." ";       
        }
        else{
            $sql = "UPDATE $table_name SET ".implode(",", $append)." WHERE ";        
            $sql .= " ". $where ." ";
        }
        
        return $sql; 
    } 
} 

// Create a mysql where clause
// $where: Pass either a array or string for where clause
if (!function_exists('create_where_clause')){

    function create_where_clause($where, $operator="AND") 

    {

    	$sql = "";

        $append_where = array();

        if(is_array($where)){

            foreach($where as $key => $val){

        	    if($val!=""){

        	        // check if there is any comparison operators specified.

                    $key = trim($key);

        	        $key_split = preg_split("/[\\s]/", $key); 

                    if(isset($key_split[1])){

                        $append_where[] = trim($key_split[0]) . " ". trim($key_split[1])." '" . trim($val) ."'";

                    }

                    else{

                	   $append_where[] = trim($key) . " = '" . trim($val) ."'";

                    } 

                }           

            } 

            

            $sql .= " WHERE ". implode(" $operator ", $append_where) ." ";       

        }

        else{

            $sql .= " WHERE ". $where ." ";

        }

        

        return $sql; 

    } 

} 


/** 
 * create bulk insert statement
 * @param string Table name.
 * @param array Array of column names.
 * @param array Associative array of data to insert. Keys of each row should be column names. Order of the keys should match the order of values in the second parameter.
 * @param boolean TRUE if to use INSERT IGNORE otherwise FALSE. Defaults to FALSE.
 * @return string 
*/
if (!function_exists('bulk_insert_sql')){
    function bulk_insert_sql($table_name, $cols=array(), $insert_data=array(), $ignore_unique=FALSE) 
    {
        $sql = "INSERT ".(($ignore_unique==TRUE)? " IGNORE " : "")." INTO ". $table_name ." ( ". implode(',', $cols) ." ) values ";
        
        $sql_row_data = array();
        foreach($insert_data as $insert_row){
            // do string escape on each value in the array 
            $insert_row_modified = array_map('do_mysql_escape', $insert_row);
            $sql_row_data[] = " ( ". implode(',', $insert_row_modified) ." ) ";
        } 
        // conatenate all row data string
        $sql .= implode(',', $sql_row_data);
        
        return $sql;       
    } //EO function 

}


/**
 * escape each value in the array 
 */
if (!function_exists('do_mysql_escape')){
    function do_mysql_escape($val){
        return $val;
    }
}

/**
 * Delete a file, or a folder and its contents (recursive algorithm)
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.3
 * @link        http://aidanlister.com/2004/04/recursively-deleting-a-folder-in-php/
 * @param       string   $dirname    Directory to delete
 * @return      bool     Returns TRUE on success, FALSE on failure
 */
if (!function_exists('rmdirr')){ 
    function rmdirr($dirname)
    {
        // Sanity check
        if (!file_exists($dirname)) {
            return false;
        }
      
        // Simple delete for a file
        if (is_file($dirname) || is_link($dirname)) {
            return unlink($dirname);
        }
      
        // Loop through the folder
        $dir = dir($dirname);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
      
            // Recurse
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }
      
        // Clean up
        $dir->close();
        return rmdir($dirname);
    }
}


if (!function_exists('set_value')){ 

    function set_value($var_name="",$default_val=""){

        if(isset($_POST[$var_name])){

            return $_POST[$var_name];

        }
        else{
            return $default_val;
        }

    }

} 

/** 
 * Get a given absolute file path converted to its equivalent url or a given url converted to its equivalent absolute file path.
 * If both filepath and url are given it defaults to filepath.   
 * @param string filepath Absolute file path.
 * @param string url HTTP url.
 * @param string base_dirpath Absolute base directory path.
 * @param string base_url Base URL. 
 * @return string 
*/
if (!function_exists('filepath_url')){
    function filepath_url($filepath="", $url="", $base_dirpath="", $base_url="") 
    {
        // to do      
    } 
}

/** 
 * Get a file's path from the given directory path.
 * @param string dir_path The directory path to fetch a file from.
 * @return string File path of a file from the given directory. 
*/
if (!function_exists('my_get_dir_file')){
    function my_get_dir_file($dir_path=""){
    	$file_path = ""; 
        if ($handle = opendir($dir_path)) {
            while (false !== ($dir_entry = readdir($handle))) {
                if ($dir_entry != "." && $dir_entry != ".." && $dir_entry != "thumbs.db") { 
                    $file_path = $dir_path."/".$dir_entry;
                    break; // just get one file and break out of the loop      
                }
            } // while
        }
        return $file_path;
    }
}


// check if directory has a file apart from the system files 
if (!function_exists('dir_is_empty')){ 
    function dir_is_empty($dirname)
    {
        // Sanity check
        if (!is_dir($dirname)) {
            return false;
        }
      
        // Loop through the folder
        $dir = dir($dirname);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..' || $entry == 'thumbs.db') {
                continue;
            }
            else{
                return TRUE;
            }
      
            // Recurse
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }
      
        // Clean up
        $dir->close();
        
        // if it reaches here then there was no file.
        return FALSE;
    }
}
if (!function_exists('in_array_r')){
    function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return isset($item['ordering'])?$item['ordering']:true;
        }
    }

    return false;
}
}
if (!function_exists('send_mail')){
    function send_mail($to, $subject,$message,$fromName="",$fromEmail=""){
        if($fromEmail == ""){
            $fromEmail = get_option( 'admin_email' );
        }
        if($fromName == ""){
            $user = get_user_by( 'email', $fromEmail );
            $fromName = $user->user_nicename;
        }
        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: '.$fromName.' <'.$fromEmail.'> \r\n';
        /*$headers .= 'Cc: welcome@example.com' . "\r\n";
        $headers .= 'Bcc: welcome2@example.com' . "\r\n";*/

        // Send email
        if(mail($to,$subject,$message,$headers)):
            $successMsg = 'Email has sent successfully.';
        else:
            $errorMsg = 'Email sending fail.';
        endif;
    }
}