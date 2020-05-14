<?php
// some variables that may be needed widely in the conversation plugin

// let us put all table name variable here to make name changes easier
$table_conversation_category = $wpdb->prefix . "conversation_category";
$table_conversation_outcome = $wpdb->prefix . "conversation_outcome";
$table_conversation_territory = $wpdb->prefix . "conversation_territory";
$table_conversation_role = $wpdb->prefix . "conversation_role";
$table_conversation_activity = $wpdb->prefix . "conversation_activity";
$table_conversation_users = $wpdb->prefix . "conversation_users";
$table_conversations = $wpdb->prefix . "conversations";


// absolute base path
$conversations_images_basepath = str_replace('\\', '/', ABSPATH."wp-content/plugins/conversations/images");
// base url
$conversations_images_baseurl = plugins_url().'/conversations/images';