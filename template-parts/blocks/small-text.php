<?php

/**
 * Small Text Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$small_text = get_field('small_text');
?>

<div class="small-text">
    <?php echo $small_text; ?>
</div>