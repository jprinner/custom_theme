<?php

/**
 * Image & Text Row
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title = get_field('title');
$text = get_field('text');
$style = get_field('style');
$image = ($bgImg = get_field('image')) ? $bgImg : get_template_directory_uri() . '/images/woman-on-phone.png';


?>
<section class="image-text-row-block row-full">
    <div class="container <?php echo $style; ?>">
        <div class="row <?php echo ($style=='blue-background-image') ? 'd-flex align-items-center': '';?>">
            <div class="col p-0 mr-3 image-row <?php echo ($style=='image-dots') ? 'pb-5': '';?>">
                <?php if ($image): 
                    if ($style=='image-dots'): ?>
                        <div class="dots-container">
                            <svg width="100%" height="100%"><pattern id="a" x="0" y="0" width="14" height="14" patternUnits="userSpaceOnUse" patternContentUnits="userSpaceOnUse"><circle cx="2" cy="2" r="2" fill="#D1D3D4"/></pattern><rect width="100%" height="100%" fill="url(#a)"/></svg>
                        </div>
                        <img src="<?php echo $image; ?>" alt="logo" width="300" height="200" class="border-radius-20">
                    <?php elseif($style=='blue-background-image'): ?>
                        <div class="icons-container"> 
                            <div class="blue-banner border-radius-20" style="background-image:url(<?php echo $image; ?>);">
                            </div>
                        </div>
                    <?php elseif($style=='text-right-overlapping-image-left'): ?>
                        <div class="icons-container"> 
                            <div class="full-width-image border-radius-20" style="background-image:url(<?php echo $image; ?>);">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>  
            </div>
            <div class="col p-md-0 ml-sm-3 text-col <?php echo ($style=='text-right-overlapping-image-left') ? 'd-flex align-items-center': '';?>">
                <div class="text-wrapper <?php echo ($style=='text-right-overlapping-image-left') ? 'py-4': '';?>">
                    <?php echo ($title) ? '<h2>'.$title .'</h2>' : ''; ?>
                    <?php echo ($text) ? '<p>'.$text .'</p>' : ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>
