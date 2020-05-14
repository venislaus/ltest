<link rel="stylesheet" href="<?php echo plugins_url().'/conversations/css/styles.css';?>" type="text/css" media="screen" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<div id="mobile-wrap">
<div class="header_logo">
<img src="<?php echo plugins_url() .'/conversations/images/optus.png';?>" alt="optus" width="140" />
<h4>Conversation Tracker</h4>
	<h5>Conversation Topic</h5>
</div>

<div class="sub_header_logo"></div>
<form action="" method="post" name="cForm">
    <div class="conversation_form">
        <?php
        $userKey = md5($_COOKIE['cUserId'].time().rand(1,99999));

        $sql = "SELECT * FROM ".$table_conversation_category." order by ordering DESC";
        $category_items = $wpdb->get_results($sql, ARRAY_A);

        if(!empty($category_items)){
            foreach($category_items as $item){ ?>
            <div class="one_half">
                <a href="javascript:void(0)" onclick="startConversation('<?php echo $item['id'];?>')">
                    <?php if(!empty($item['category_image'])){?>
                        <div class="con-icon"><img src="<?php echo plugins_url() ."/conversations/images/category/".$item['id']."/".$item['category_image']; ?>" /></div>
                    <?php }else{?>
                        <span>&nbsp;</span>
                    <?php }?>
                    <span class="con-title"><?php echo $item['category_name'];?></span>
                </a>
            </div>
        <?php }
        }
        ?>
    </div>
    <input type="hidden" name="userKey" id="userKey" value="<?php echo $userKey?>">
    <input type="hidden" name="cId" id="cId" value="">
</form>
</div>
<script>
    jQuery.noConflict();
    function startConversation(cId){
        jQuery("#cId").val(cId);
        document.cForm.submit();
    }
</script>