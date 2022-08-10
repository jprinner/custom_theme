<?php
/**
 * Template part for displaying provider in single-provider.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package HSO
 */

$logo = get_field('logo');
//$partner = get_field('partner');
$hide_cta = get_field('hide_cta');

$title = ($overrideTitle = get_field('main_title')) ? $overrideTitle : get_the_title();
$overview = get_field('provider_overview');
$hero_img = ($heroImg = get_field('hero_image')) ? $heroImg : get_template_directory_uri() . '/images/provider-hero.png';

$blue_banner = get_field('blue_banner');
$bb = get_template_directory_uri() .'/images/bb-icon.svg';
$bb_icon = ($bb_over = $blue_banner['icon_override']) ? $bb_over['url'] : $bb;

$internet_check = get_field('internet_check');
$tv_check = get_field('tv_check');
$bundles_check = get_field('bundles_check');




if( get_field('featured_boxes') ) {
    
$featured_boxes = get_field('featured_boxes'); 
    
$tv = $featured_boxes['tv'];
$internet = $featured_boxes['internet'];
$bundles = $featured_boxes['bundles'];
$phone = $featured_boxes['phone'];
$security_tools = $featured_boxes['security_tools'];
$order_list = $featured_boxes['order'];	
$source = $featured_boxes['source'];
    
}    

$cta_arr = get_ctas(get_the_ID());

//Provider Plans Info
$show_plans = get_field('show_plans_page');
$plan_page = isset($_GET['plans']);
$plan_faq = get_field('separate_faqs');

$plan_link = get_the_permalink() . '?plans=show';

//dataLayer info
if (isset($cta_arr['cta_link'])){
	$providerOutboundClick = dataLayerOutboundLinkClick( get_the_id(), "Internet", $cta_arr['cta_link'] );
}
if (isset($cta_arr['cta_link2'])){
	$providerOutboundClick2 = dataLayerOutboundLinkClick( get_the_id(), "Internet", $cta_arr['cta_link2'] );
}

$providersOnLoad =  dataLayerProductDetail('Providers Page', get_the_title().' Providers', get_the_ID(), get_the_title(), 'Provider', $cta_arr['variantProvider']['text'] );


?>
 
  
  
<section class="provider-hero">

	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumbs', null, array( ) ); ?>
	</div>

	<!-- <?php if($logo) : ?>
		<div class="logo-mobile">
			<div class="container">
				<img src="<?php echo $logo ?>" alt="<?php echo get_the_title() ?>" width="170" height="55">
			</div>
		</div>
	<?php endif; ?> -->

	<div class="container">

		<div class="provider-top-content d-flex flex-column <?php if($blue_banner && $blue_banner['display'] !== 'none') : echo 'has-blue-banner'; endif; ?>">

			<div class="nav-container order-1 order-md-0">
				<div class="nav-items">
					<a href="<?php echo get_the_permalink() ?>" class="<?php if(!$plan_page) : echo 'active'; endif; ?>">Overview</a>
					<?php if($show_plans) : ?>
						<a href="#" class="plans-page <?php if($plan_page) : echo 'active'; endif; ?>">Plans</a>
					<?php endif; ?>
				</div>
				<?php if($plan_page) : ?>
					<div class="plan-logo">
						<?php if($logo) : ?>
							<div class="logo-container">
								<img src="<?php echo $logo ?>" alt="<?php echo get_the_title() ?>" height="50" width="150">
							</div>
							<div class="gray-bar"></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			
			<?php if($blue_banner && $blue_banner['display'] !== 'none') : ?>
			<section class="blue-banner-block order-0 row-full mb-sm-4 mb-lg-0 order-md-1">
				<div>
					<div class="banner-outside position-relative">
						<div class="banner-bg"></div>
						<div class="container">
							<div class="content d-md-flex align-items-md-center">
								<div class="d-none d-md-flex icon-container flex-shrink-0">
									<img src="<?php echo $bb_icon; ?>" alt="banner icon" height="40" width="43">
								</div>
								<div>
									<?php 
										if($blue_banner['display'] == 'separate' && $plan_page) : 
											echo $blue_banner['banner_plans'];
										else :
											echo $blue_banner['content'];
										endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php endif; ?>
		</div>

		<?php if(!$plan_page) : ?>
			<div class="hero-content">

				<div class="img-container">
					<img src="<?php echo $hero_img  ?>" alt="provider hero img" width="470" height="400">
					<div class="dots-container">
						<svg width="100%" height="100%"><pattern id="a" x="0" y="0" width="14" height="14" patternUnits="userSpaceOnUse" patternContentUnits="userSpaceOnUse"><circle cx="2" cy="2" r="2" fill="#D1D3D4"/></pattern><rect width="100%" height="100%" fill="url(#a)"/></svg>
					</div>
				</div>

				<div class="content-container">
					<?php if($logo) : ?>
						<div class="logo-container">
							<img src="<?php echo $logo ?>" alt="<?php echo get_the_title() ?>" width="170" height="55">
						</div>
					<?php endif; ?>
					<h1><?php echo $title ?></h1>
					<?php if($overview) : ?>
						<div class="content">
							<?php echo $overview ?>
						</div>
					<?php endif; ?>

					<div class="btn-container">
						<?php if(!$hide_cta) : ?>
							<?php if(isset($cta_arr['cta_text']) && $cta_arr['cta_text']) : ?>
								<a href="<?php echo $cta_arr['cta_link'] ?>" class="cta_btn font-weight-bold" <?php echo $cta_arr['target'] ?> onClick="<?php echo $providerOutboundClick ?>"><?php echo $cta_arr['cta_text'] ?></a>
							<?php endif; ?>
							<?php if(isset($cta_arr['cta_text2']) && $cta_arr['cta_text2']) : ?>
								<a href="<?php echo $cta_arr['cta_link2'] ?>" class="plans-btn font-weight-bold" <?php echo $cta_arr['target2'] ?> onClick="<?php echo $providerOutboundClick2 ?>"><?php echo $cta_arr['cta_text2'] ?></a>
							<?php elseif($show_plans) : ?>
								<a href="#" class="plans-page plans-btn">View Plans</a>
							<?php endif; ?>
						<?php else: ?>
							<?php if($show_plans) : ?>
								<a href="#" class="plans-page plans-btn">View Plans</a>
							<?php endif; ?>
						<?php endif; ?>	
					</div>
				</div>

			</div>
		<?php endif; ?>
	</div>

</section>

<section>
	<div class="container">
		<?php the_content(); ?>
	</div>
</section>

<?php 
	if($plan_faq && $plan_page) : 
		get_template_part('/template-parts/faq', null, ['unique' => $plan_faq]);
	else: 
		get_template_part('/template-parts/faq', null, []);
	endif;
?>

<?php get_template_part('/template-parts/related_posts', null, ['container' => true]); ?>

<script>
<?php echo $providersOnLoad ?>
</script>
