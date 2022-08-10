<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * Template Name: Template - Paid City Lander
 * Template Post Type: locations
 * @package HSO
 */

get_header();

//require get_theme_file_path( '/template-parts/zip-search-popup.php' );
while ( have_posts() ) :
	the_post();
	$post_parent_id = $post->post_parent;
	$post_parent_title = get_field('abbreviation',$post_parent_id);
	$post_parent_title = strtoupper($post_parent_title);
	$city = get_the_title();
	$state = $post_parent_title;
	$state_perm = get_home_url().'/'.strtolower($state);
	$hero_img = get_field('main_hero_image');
	$hero_img = (!empty($hero_img)) ? wp_get_attachment_image($hero_img['id'], 'full', null, array("class" => 'hero_img')) : '<img width="976" height="500" src="'.get_template_directory_uri() . '/images/city-paid-lander-header.png" data-src="'.get_template_directory_uri() . '/images/city-paid-lander-header.png" class="hero_img lazyloaded" alt="people on laptops and smiling">';

	?>

	<main class="locations-main">
		<div class="container desktop-hidden tablet-hidden">
			<?php get_template_part( 'template-parts/breadcrumbs', null, array( 'is_location' => true, 'city' => $city, 'state' => $state, 'state_permalink' => $state_perm, 'exclude_advertiser_disclosure_link' => false)); ?>
		</div>
		<section class="paid-city-lander-header row-full">
			<div class="container">
				<div class="mobile-hidden">
					<?php get_template_part( 'template-parts/breadcrumbs', null, array( 'is_location' => true, 'city' => $city, 'state' => $state, 'state_permalink' => $state_perm, 'exclude_advertiser_disclosure_link' => false)); ?>
				</div>
				<div class="zipcode_wrapper">
					<div class="zipcode_inner_wrap">
						<h1 class="mb-0">Compare the Best Internet Providers in <span><?php echo $city.', '.$state; ?><span></h1>
					</div>	
				</div>
				<?php echo $hero_img; ?>
			</div>
		</section>

		<section>
			<div class="container locations-content">
				<?php the_content(); ?>
			</div>
		</section>
		<section class="related-posts">
		<div class="container">
			<?php require get_theme_file_path( '/template-parts/related_posts.php' ); ?>
		</div>
	</section>
	</main><!-- #main -->
<?php
	endwhile;
	wp_reset_query();
get_footer();