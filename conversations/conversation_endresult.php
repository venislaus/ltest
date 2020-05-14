<link rel="stylesheet" href="<?php echo plugins_url().'/conversations/css/styles.css';?>" type="text/css" media="screen" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
<div id="mobile-wrap">
<div class="header_logo">
<img src="<?php echo plugins_url() .'/conversations/images/optus.png';?>" alt="optus" width="140" />
<h4>Conversation Tracker</h4>
	<h5>Customer Sentiment</h5>
</div>
<form action="<?php echo site_url();?>/success" method="post" name="rForm">
    <div class="conversation_form result">
        <?php
        $arrResults = array(1=>"Positive",2=>"Indifferent",3=>"Negative");

        foreach($arrResults as $key => $item){ ?>
            <div class="one_half">
                <a href="javascript:void(0)" onclick="resultConversation('<?php echo $key;?>')">
                    <div class="con-icon"><img src="<?php echo plugins_url() ."/conversations/images/".$item.".png"; ?>" /></div>
                    <span class="con-title"><?php echo $item;?></span>
                </a>
            </div>
        <?php }
        ?>
    </div>
    <input type="hidden" name="trackerId" id="trackerId" value="<?php echo $conversation_id;?>">
    <input type="hidden" name="endresult_id" id="endresult_id" value="">
</form>
</div>
<script>
    jQuery.noConflict();
    function resultConversation(oId){
        jQuery("#endresult_id").val(oId);
        document.rForm.submit();
    }
</script>