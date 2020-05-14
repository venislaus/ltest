<link rel="stylesheet" href="<?php echo plugins_url().'/locations/css/styles.css';?>" type="text/css" media="screen" />
<div class="locationMain">
    <div>
        <?php
        $sql = "SELECT * FROM ".$table_locations." order by location_name ASC";
        $location_items = $wpdb->get_results($sql, ARRAY_A);

        $defaultId = '';
        $timings = $phone = '';
        if(!empty($location_items)){
            $i = 0;
            ?>
            <i class=" fas fa-map-marker"></i><select class="locationName" id="location_name">
                <?php
                foreach($location_items as $item) {
                    if($i==0){
                        $defaultId = $item['id'];
                        $timings = $item['location_timings'];
                        $phone = $item['phone'];
                    }
                    ?>
                    <option value="<?=$item['id']?>" data-timings="<?=$item['location_timings']?>" data-phone="<?=$item['phone']?>" <?=($i==0)?'selected':''?>>
                        <?=stripslashes($item['location_name'])?>
                    </option>

                    <?php
                    $i = $i + 1;
                }
                ?>
            </select>
        <?php }
        echo do_shortcode( '[zoom_api_link meeting_id="816521991" link_only="no"]' );
        ?></div>
    <div><i class=" icomoon-the7-font-the7-clock-00"></i><span id="locationTimings"><?=$timings?></span></div>
    <div><i class=" the7-mw-icon-phone-bold"></i><span id="locationPhone"><?=$phone?></span></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    // anonymous function to pass in the jquery object. The usual $(document)... throws a "$ is not a function error".
    jQuery(function($){
        $('#location_name').change(function(){
            let timings = $(this).find(':selected').data('timings');
            let phone = $(this).find(':selected').data('phone');
            $('#locationTimings').html(timings);
            $('#locationPhone').html(phone);
        });
    });
</script>