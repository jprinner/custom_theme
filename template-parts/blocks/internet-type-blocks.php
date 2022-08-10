<?php 

/**
 * Internet Type Blocks Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$data_raw = do_shortcode('[internet_types_availability return="data"]');
$data_raw = explode( ', ', $data_raw);
$arr_types = [];
$fiber_manual_override = get_field('fiber_manual_override');
$cable_manual_override = get_field('cable_manual_override');
$dsl_manual_override = get_field('dsl_manual_override');
$satellite_manual_override = get_field('satellite_manual_override');
$fixed_wireless_manual_override = get_field('fixed_wireless_manual_override');
$fiveg_manual_override = get_field('fiveg_manual_override');

if ((!$fiber_manual_override && in_array('fiber', $data_raw)) || ($fiber_manual_override && get_field('fiber_show'))){
    $arr_types['fiber'] = 'Fiber';
}
if ((!$cable_manual_override && in_array('cable', $data_raw)) || ($cable_manual_override && get_field('cable_show'))){
    $arr_types['cable'] = 'Cable';
}
if ((!$dsl_manual_override && in_array('dsl', $data_raw)) || ($dsl_manual_override && get_field('dsl_show'))){
    $arr_types['dsl'] = 'DSL';
}
if ((!$satellite_manual_override && in_array('satellite', $data_raw)) || ($satellite_manual_override && get_field('satellite_show'))){
    $arr_types['satellite'] = 'Satellite';
}
if ((!$fixed_wireless_manual_override && in_array('fixed_wireless', $data_raw)) || ($fixed_wireless_manual_override && get_field('fixed_wireless_show'))){
    $arr_types['fixed_wireless'] = 'Fixed Wireless';
}
if ((!$fiveg_manual_override && in_array('fiveg', $data_raw)) || ($fiveg_manual_override && get_field('fiveg_show'))){
    $arr_types['fiveg'] = '5G';
}
?>

<section class="internet-type-blocks container">
    <div class="row">
        <?php foreach($arr_types as $key => $value): 
            if ($key == 'fixed_wireless'){
                $link_part = 'fixed-wireless-internet';
            } elseif ($key == 'fiveg'){
                $link_part = '5g-internet';
            } else {
                $link_part = $key.'-internet';
            }
            ?>
            <div class="type-block col-12 col-md-6 mb-3 px-0 px-md-2">
                <a href="<?php echo home_url().'/internet/'.$link_part;?>">
                    <div class="type-block-wrapper d-flex border-radius-20 p-4">
                        <div class="icon-container mr-2">
                            <img src="<?php echo get_template_directory_uri() . '/images/internet-types/'.$key.'.svg'; ?>" alt="<?php echo $value; ?> Icon" <?php echo ($key == 'fiber' || $key == 'cable') ? 'width="50" height="50"' : 'width="50" height="50"'; ?>>
                        </div>
                        <div>
                            <h3><?php echo $value; ?></h3>
                            <p><?php echo get_field($key.'_text'); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

