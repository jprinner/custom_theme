<?php

use ZipSearch\ProviderSearchController as ProviderSearchController;
use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;

/**
 * Green Statistics Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

global $city;
global $state;
global $zip_results_arr;
$title = get_field('title');
$enter_data_manually = get_field('enter_data_manually');
$green_statistics = get_field('green_statistics');

if (!$title){
    $args = array(
        'numberposts'=> 1,
        'post_type'  => 'locations',
        'meta_key'   => 'abbreviation',
        'meta_value' => $state,
    );
    $query = get_posts($args);
    $state_long = $query[0]->post_title;
    $title = 'Internet Statistics for '.$city.', '.$state_long;
}

if (!$enter_data_manually):
    $zip_arr = (new ProvidersDBConnection())->getZipsByCity($city, $state);
    $args = [
        'is_city' => true,
        'zip_arr' => $zip_arr,
        'city' => $city,
        'state' => $state,
        'is_programmatic_city_page' => false
    ];
    $zip_results_arr = (new ProviderSearchController())->getAllProviders($args);
endif;    

?>

<section class="green-statistics row-full pt-5 pb-4">
    <div class="container">
        <h2 class="text-center mb-5 px-4"><?php echo $title; ?></h2>
        <div class="row px-md-6 px-lg-0">
            <?php foreach($green_statistics as $stat): 
                if (!$enter_data_manually):
                    switch ($stat['data_type']) {
                        case 'internet-service-providers-count':
                            $data = do_shortcode('[provider_count]');
                            if (!$data){
                                $data = 'N/A';
                            }
                            break;
                        case 'starting-price':
                            $data = min(array_column($zip_results_arr['internet'], 'cost'));
                            if (!$data){
                                $data = 'N/A';
                            } else {
                                $data = '$'.$data;
                            }
                            break;
                        case 'max-download-speed':
                            $data = max(array_column($zip_results_arr['internet'], 'download_speed'));
                            //if it's gigs
                            if (!$data){
                                $data = 'N/A';
                            } else {
                                if (strlen($data)>=4){
                                    $data = $data/1000;
                                    $data = round($data, 1);
                                    $data = $data.' Gbps';
                                } else {
                                    $data = $data.' Mbps';
                                }
                            }
                            break;
                        case 'fastest-connection-type':
                            $data_raw = do_shortcode('[internet_types_availability return="data"]');
                            $data_raw = explode( ', ', $data_raw);
                            if (in_array('fiber', $data_raw)){
                                $data = 'Fiber';
                            } elseif (in_array('cable', $data_raw)){
                                $data = 'Cable';
                            } elseif (in_array('dsl', $data_raw)){
                                $data = 'DSL';
                            } elseif (in_array('wireless', $data_raw)){
                                $data = 'Wireless';
                            } elseif (in_array('satellite', $data_raw)){
                                $data = 'Satellite';
                            } else {
                                $data = 'N/A';
                            }
                            break;      
                    }
                else:
                    $data = $stat['data_value'];
                    $data_name = $stat['data_name'];     
                endif;   

                //add in default names
                switch ($stat['data_type']) {
                    case 'internet-service-providers-count':
                        $data_name = ($stat['data_name']) ? $stat['data_name'] : 'Internet Service Providers:';
                        break;
                    case 'starting-price':
                        $data_name = ($stat['data_name']) ? $stat['data_name'] : 'Plans Start From:';
                        break;
                    case 'max-download-speed':
                        $data_name = ($stat['data_name']) ? $stat['data_name'] : 'Top Download Speed:';

                        break;
                    case 'fastest-connection-type':
                        $data_name = ($stat['data_name']) ? $stat['data_name'] : 'Fastest Connection Type:';

                        break;      
                }
                ?>

                <div class="col-12 col-md-6 col-lg mb-3 data-col">
                    <p class="text-center mb-2"><?php echo $data_name; ?></p>
                    <h2 class="text-center"><?php echo $data; ?></h2>
                </div>
            <?php endforeach; ?>  
        </div>
    </div>
</section>