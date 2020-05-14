<link rel="stylesheet" href="<?php echo plugins_url().'/events/css/styles.css';?>" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url().'/events/slick/slick.css'?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url().'/events/slick/slick-theme.css'?>"/>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
    jQuery('.slidesEvents').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        centerMode: true,
        focusOnSelect: true
    });
});
</script>
<?php
$sql = "SELECT * FROM ".$table_event_category." where id =".$atts['category']." order by ordering ASC";
$event_cat = $wpdb->get_results($sql, ARRAY_A);
if(!empty($event_cat)){
    foreach($event_cat as $cat) {
    ?>
    <div class="categoryTitle"><?=$cat['category_name']?></div>
    <?php
    $sql = "SELECT * FROM ".$table_events." WHERE category_id ='".$cat['id']."' order by ordering ASC";
    $event_items = $wpdb->get_results($sql, ARRAY_A);

    if(!empty($event_items)){
        ?>
        <div class="slidesEvents">
       <?php foreach($event_items as $item) {
            ?>
            <a class="" href="<?php echo fEventDetailUrl($item['events_name'],$item['id']);?>">
                <img src="<?php echo plugins_url() ."/events/images/events/thumbsize2/".$item['id']."/".$item['events_image']; ?>">
                <span class="eventDate"><?php echo date('M D',strtotime($item['events_date']));?></span>
                <span class="eventName"><?=$item['events_name']?></span>
                <span class="eventTime"><?=$item['events_time']?></span>
                <span class="eventAddress"><?=$item['events_address1']?> , <?=$item['events_address2']?></span>
            </a>
        <?php
        }?>
        </div>
    <?php }
    ?>
<?php
    }
}
?>
</ul>