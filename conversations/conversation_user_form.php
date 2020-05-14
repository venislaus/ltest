<link rel="stylesheet" href="<?php echo plugins_url().'/conversations/css/styles.css';?>" type="text/css" media="screen" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<div id="splashDiv">
    <div class="header_logo"><img src="<?php echo plugins_url() .'/conversations/images/optus.png';?>" alt="optus" width="140" /><h4>Conversation Tracker</h4></div>
    <img class="yes" src="<?php echo plugins_url() .'/conversations/images/yes.png';?>" alt="yes" />
</div>
<div id="mobile-wrap" style="display: none">
<div class="header_logo">
<img src="<?php echo plugins_url() .'/conversations/images/optus.png';?>" alt="optus" width="140" />
<h4>Conversation Tracker</h4>
<h5>About Me</h5>
</div>
<form action="" method="post">
    <div class="form_tracker">
        <label>Enter your full name</label>
        <div class="form_field">
            <input type="text" name="user_fullname" id="user_fullname">
            <div class="errorMsg" id="error_fullname"></div>
        </div>
        <label>Role</label>
        <div class="form_field">
            <?php
            $sql = "SELECT * FROM ".$table_conversation_role." order by ordering ASC";
            $role_items = $wpdb->get_results($sql, ARRAY_A);

            if(!empty($role_items)){
                ?>
                <select name="user_role" id="user_role">
                    <option value="">Select</option>
                    <?php foreach($role_items as $item){ ?>
                        <option value="<?php echo $item['id']; ?>" <?php echo ($item['id']==$_POST['role_id'])? 'selected' : ''; ?> ><?php echo $item['role_name']; ?></option>
                    <?php } ?>
                </select>
                <div class="errorMsg" id="error_userrole"></div>
            <?php } ?>
        </div>
        <label>Territory</label>
        <div class="form_field">
            <?php
            $sql = "SELECT * FROM ".$table_conversation_territory." order by ordering ASC";
            $territory_items = $wpdb->get_results($sql, ARRAY_A);

            if(!empty($territory_items)){
            ?>
            <select name="user_shopterritory" id="user_shopterritory">
                <option value="">Select</option>
                <?php foreach($territory_items as $item){ ?>
                    <option value="<?php echo $item['id']; ?>" <?php echo ($item['id']==$_POST['territory_id'])? 'selected' : ''; ?> ><?php echo $item['territory_name']; ?></option>
                <?php } ?>
            </select>
            <div class="errorMsg" id="error_shopterritory"></div>
            <?php } ?>
        </div>
        <label>Activity Type</label>
        <div class="form_field">
            <?php
            $sql = "SELECT * FROM ".$table_conversation_activity." order by ordering ASC";
            $activity_items = $wpdb->get_results($sql, ARRAY_A);

            if(!empty($activity_items)){
                ?>
                <select name="user_activity" id="user_activity">
                    <option value="">Select</option>
                    <?php foreach($activity_items as $item){ ?>
                        <option value="<?php echo $item['id']; ?>" <?php echo ($item['id']==$_POST['activity_id'])? 'selected' : ''; ?> ><?php echo $item['activity_name']; ?></option>
                    <?php } ?>
                    <option value="999999999" <?php echo (999999999==$_POST['activity_id'])? 'selected' : ''; ?> >Other</option>
                </select>
                <div class="errorMsg" id="error_useractivity"></div>
            <?php } ?>
        </div>
        <div class="form_field" style="display: none" id="divOtherActivity">
            <textarea name="user_otheractivity" id="user_otheractivity" cols="5" rows="5"></textarea>
            <div class="errorMsg" id="error_otheractivity"></div>
        </div>
    </div>
    <button type="submit" name="cmdUserForm">Next</button>
</form>
</div>
<script>
jQuery.noConflict();

jQuery("select#user_activity").change(function(){
    var thisvalue = jQuery(this).find("option:selected").text().toLowerCase();

    if(thisvalue == "other"){
        jQuery("#divOtherActivity").css("display","block");
    }else{
        jQuery("#divOtherActivity").css("display","none");
    }
});

jQuery(document).ready(function() {
    var explode = function(){
        jQuery("#splashDiv").css("display","none");
        jQuery("#mobile-wrap").css("display","block");
    };
    setTimeout(explode, 4000);

    jQuery('form').submit(function() {

        jQuery('#error_fullname').html('');
        jQuery('#error_shopterritory').html('');
        jQuery('#error_userrole').html('');
        jQuery('#error_useractivity').html('');
        jQuery('#error_otheractivity').html('');

        if(jQuery('#user_fullname').val() == ""){
            jQuery('#error_fullname').html("Please enter fullname"); return false;
        }else if(jQuery('#user_fullname').val().length < 3){
            jQuery('#error_fullname').html("Please enter atleast 3 characters"); return false;
        }else if(jQuery('#user_role').val() == ""){
            jQuery('#error_userrole').html("Please choose role"); return false;
        }else if(jQuery('#user_shopterritory').val() == ""){
            jQuery('#error_shopterritory').html("Please choose territory"); return false;
        }else if(jQuery('#user_activity').val() == ""){
            jQuery('#error_useractivity').html("Please choose activity type"); return false;
        }else if(jQuery('#user_activity').val() == "999999999" && jQuery('#user_otheractivity').val() == ""){
            jQuery('#error_otheractivity').html("Please enter other activity type"); return false;
        }else{
            return true;
        }
        return false;
    });
});
</script>