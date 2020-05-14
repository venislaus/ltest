<link rel="stylesheet" href="<?php echo plugins_url().'/conversations/css/styles.css';?>" type="text/css" media="screen" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<div id="mobile-wrap">
<div class="header_logo">
<!--<a href="<?php //echo site_url();?>/conversation" class="back-btn"><img src="<?php //echo plugins_url() .'/conversations/images/back.png';?>" alt="back" width="32" /></a>-->
<img src="<?php echo plugins_url() .'/conversations/images/optus.png';?>" alt="optus" width="140" />
<h4>Conversation Tracker</h4>
	<h5>Conversation Outcome</h5>
</div>
<form action="<?php echo site_url();?>/result" method="post" name="oForm">
    <div class="conversation_form">
        <?php
        $sql = "SELECT * FROM ".$table_conversation_outcome." order by ordering DESC";
        $outcome_items = $wpdb->get_results($sql, ARRAY_A);

        if(!empty($outcome_items)){
            foreach($outcome_items as $item){ ?>
                <div class="one_half">
                    <a href="javascript:void(0)" onclick="endConversation('<?php echo $item['id'];?>')">
                        <?php if(!empty($item['outcome_image'])){?>
                            <div class="con-icon"><img src="<?php echo plugins_url() ."/conversations/images/outcome/".$item['id']."/".$item['outcome_image']; ?>" /></div>
                        <?php }else{?>
                            <span>&nbsp;</span>
                        <?php }?>
                        <span class="con-title"><?php echo $item['outcome_name'];?></span>
                    </a>
                </div>
            <?php }
        }
        ?>
    </div>
    <input type="hidden" name="trackerId" id="trackerId" value="<?php echo $conversation_id;?>">
    <input type="hidden" name="outcome_id" id="outcome_id" value="">
</form>
</div>
<script>
    jQuery.noConflict();
    function endConversation(oId){
        jQuery("#outcome_id").val(oId);
        document.oForm.submit();
    }
</script>