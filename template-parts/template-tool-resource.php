<?php

/**
 * Template Name: Tool Resource Page
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

use ZipSearch\ProviderSearchController as ProviderSearchController;

$zip_type = ProviderSearchController::getZipType();
$types= array('Internet', 'TV', 'Bundle');
$title = get_the_title();

get_header();
?>
<div class="container">
    <div class="breadcrumb-container">
        <?php get_template_part( 'template-parts/breadcrumbs', null, array( 'exclude_advertiser_disclosure_link' => false ) ); ?>
    </div>
</div>
<section class="tool-resource-head text-center pt-5 pb-4">
	<div class="container">
		<h1><?php the_field('tool_resource_main_title'); ?></h1>
		<?php the_field('tool_resource_main_description'); ?>
	</div>
</section>
<section class="tool-resource-block-wrap">
	<div class="container">
		<?php the_content(); ?>	
	</div>
</section>
<div class="container">
    <?php require get_theme_file_path( '/template-parts/related_posts.php' ); ?>
</div>
<?php
get_footer();
