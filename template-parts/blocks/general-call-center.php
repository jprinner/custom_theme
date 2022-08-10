<?php 

/**
 * General Call Center Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$img = ($bgImg = get_field('image_override')) ? $bgImg : get_template_directory_uri() . '/images/person-laptop.png';
$provider_id = get_field('provider');
if ($provider_id){
    $partner = get_field('partner', $provider_id);
    if (!$partner){
        $call_center_hours = get_field('call_center_hours', $provider_id);
    } else {
        $buyer_id = get_field('buyer', $provider_id);
        $campaign = get_field( "campaign", $buyer_id );
        foreach($campaign as $key => $camp) {
            if($camp['campaign_name'] == $provider_id){
                $call_center_hours = $camp['call_center_hours'];
            }
        }

    }
    $cta_arr = get_ctas($provider_id, 'text-below-button-left');
}


?>

<section class="general-call-center row-full">
    <div class="container pt-0">
        <div class="header mx-0 pt-0 pt-lg-4 pb-4">
            <div class="title-container pr-5 mb-4 mb-md-0">
                <div class="pretitle font-weight-bold">Call to get started</div>
                <h2 class="mb-4"><?php echo $title ?></h2>
                <div class="descrip"> 
                    <?php if ($provider_id): ?>
                        <?php if ($call_center_hours): ?>
                            <div class="row mx-0 pb-2">
                                <?php foreach($call_center_hours as $timeslot): ?>
                                <div class="col-6 pr-4 mb-4">
                                    <p class="font-weight-bold mb-0"><?php echo $timeslot['weekday_or_weekday_range']; ?></p>
                                    <p class="mb-0"><?php echo $timeslot['time_range']; ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo $cta_arr['cta_link']; ?>" class="cta_btn" <?php echo $cta_arr['target']; ?>><?php echo $cta_arr['cta_text']; ?></a>
                        <?php if ($cta_arr['cta_link2']): ?>
                            <a href="<?php echo $cta_arr['cta_link2']; ?>" <?php echo $cta_arr['target2']; ?>><?php echo $cta_arr['cta_text2']; ?></a>
                        <?php endif; ?> 
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="bg-container pl-5">
            <img src="<?php echo $img ?>" alt="customer service" width="325" height="400">
            <div class="blue-bg ml-5"></div>
        </div>
    </div>
</section>