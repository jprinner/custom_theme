<?php 
    use ZipSearch\ProviderSearchController as ProviderSearchController;
    use ZipSearch\BDAPIConnection as BDAPIConnection;
    use ZipSearch\ProvidersDBConnection as ProvidersDBConnection;
?>

<div class="tab-content zip-tiles" id="typeTabContent">
	<div class="tab-pane fade <?php echo $internet_active.' '.$internet_show; ?> internet-search" id="internet-search" role="tabpanel" aria-labelledby="internet-search-tab">
		<?php 
		$highest_download_speed = $highest_download_speed_provider = '';
		if (empty($results_arr['internet'])): 
			$highest_download_speed_arr = (new ProvidersDBConnection())->getHighestDownloadSpeedWithProvider($zip_arr);
			if (!empty($highest_download_speed_arr)){
				$highest_download_speed = $highest_download_speed_arr->max_downstream_speed;
				$highest_download_speed_provider = $highest_download_speed_arr->hso_provider;
			}
			?>
			<div class="container">
				<h2 class="no-results-header">No Results found for "<?php echo $no_results; ?>"</h2>
				<p class="demote"> Try searching again using different service type or zip code. </p>
			</div>
			<div style="display:none;" class="highest-download-speed"><?php echo $highest_download_speed; ?></div>
			<div style="display:none;" class="highest-download-speed-provider"><?php echo $highest_download_speed_provider; ?></div>
           <script> function zipSearchDataInternetWrapper() { } </script>
			<?php 
		else:	
				$download_speed_arr_col = array_column($results_arr['internet'], 'download_speed');
				$download_speed_arr_col = array_search(max($download_speed_arr_col), $download_speed_arr_col);
				$highest_download_speed = $results_arr['internet'][$download_speed_arr_col]['download_speed'];
				$highest_download_speed_provider = $results_arr['internet'][$download_speed_arr_col]['name'];

				?>
					<div style="display:none;" class="highest-download-speed"><?php echo $highest_download_speed; ?></div>
					<div style="display:none;" class="highest-download-speed-provider"><?php echo $highest_download_speed_provider; ?></div>

				<?php
				foreach($results_arr['internet'] as $key => $provider): 

					$hide_class = '';
					//add class to third+ items
					if ($key > 1){
						$hide_class = 'provider-hidden';
					}

					$logo_id = get_post_meta($provider['id'], 'logo', true);
					$logo = wp_get_attachment_image($logo_id, 'medium');
					$download_speed = $provider['download_speed'];
					$upload_speed = $provider['upload_speed'];
					$internet_info = get_field('internet', $provider['id']);
					$contract = $internet_info['contract_length'];
					$unit = $internet_info['unit'];
                    $has_plans = get_field('show_plans_page', $provider['id']);
					$default_na_text= $internet_info['default_not_available_text'];
					
					if (isset($provider['connection_type']) && $provider['connection_type'] != NULL){
						switch ($provider['connection_type']) {
	                        case 'Cable':
	                            $internet_plan_highlights = $internet_info['cable_connection']['cable_plan_highlights'];
	                            $internet_terms_conditions = $internet_info['cable_connection']['cable_terms_&_conditions'];
	                            break;
	                        case 'Fiber':
	                            $internet_plan_highlights = $internet_info['fiber_connection']['fiber_plan_highlights'];
	                            $internet_terms_conditions = $internet_info['fiber_connection']['fiber_terms_&_conditions'];
	                            break;
	                        case 'DSL':
	                            $internet_plan_highlights = $internet_info['dsl_connection']['dsl_plan_highlights'];
	                            $internet_terms_conditions = $internet_info['dsl_connection']['dsl_terms_&_conditions'];
	                            break;
	                        case 'Satellite':
	                            $internet_plan_highlights = $internet_info['satellite_connection']['satellite_plan_highlights'];
	                            $internet_terms_conditions = $internet_info['satellite_connection']['satellite_terms_&_conditions'];
	                            break;
	                        default:
		                        $internet_plan_highlights = $internet_info['plan_highlights'];
								$internet_terms_conditions = $internet_info['terms_&_conditions'];
	                    }
					} else {
						$internet_plan_highlights = $internet_info['plan_highlights'];
						$internet_terms_conditions = $internet_info['terms_&_conditions'];
					}      
					if ($internet_plan_highlights == ''){
						$internet_plan_highlights = $internet_info['plan_highlights'];
					}
					if ($internet_terms_conditions == ''){
						$internet_terms_conditions = $internet_info['terms_&_conditions'];
					}

					$cta_count = 'cta-1';
					$cta_arr = get_ctas($provider['id']);

					if (isset($cta_arr['cta_link2'])){
						$cta_count = 'cta-2';
					}
	                
	                $counterInternet++;
	  				
	  				$zipSearchInternetVariant['text'] = '';

	                $zipSearchInternetIndv = zipSearchLoadIndv($provider, $zipSearchInternetVariant, $counterInternet, "Internet");
	 
	                $zipSearchInternet .= $zipSearchInternetIndv;        
	        
	                $zipSearchInternetProdClick = zipSearchProdClick($zipcode, $provider, $zipSearchInternetVariant, $counterInternet, "Internet");
	                	        
	                $zipSearchInternetOutboundClick = dataLayerOutboundLinkClick( $provider['id'], "Internet", $cta_arr['cta_link'] );

	                if ($cta_arr['cta_link2']){
	        			$zipSearchInternetOutboundClick2 = dataLayerOutboundLinkClick( $provider['id'], "Internet", $cta_arr['cta_link2'] );
	        		}

					?>
				
				<div class="container zip-container mb-4 <?php echo $hide_class; ?>" data-download="<?php echo $download_speed ?>" data-upload="<?php echo $upload_speed ?>" data-cost="<?php echo $provider['cost'] ?>">
					<div class="provider-box-row">
						<div class="provider_box img-box">
							<div class="img-wrap">
								<a href="<?php echo get_permalink($provider['id']); ?>" onClick="<?php echo $zipSearchInternetProdClick ?>">
									<?php echo $logo;  ?>
								</a>
                                <?php if($has_plans) : ?>
                                    <div class="view-plan-info">
                                        <a href="/providers/<?php echo strtolower($provider['name']); ?>?plans=show">View plan information</a>
                                    </div>
                                <?php endif; ?>
							</div>
						</div>
						<div class="right-content">

							<div class="data-points data-count-3">
								<div class="data-point">
									<div class="data-container">
										<div class="label">Max Download</div><br/>
										<?php if($download_speed != 'N/A'): ?>
										<p class="large-text"><?php echo $download_speed; ?> <span class="small-text">Mbps</span></p>
										<?php else: ?>
										<p class="small-text"><?php echo $default_na_text; ?></p>
										<?php endif; ?>
									</div>
								</div>
								<div class="data-point">
									<div class="data-container">
										<div class="label">Max Upload</div><br/>
										<?php if($upload_speed != 'N/A'): ?>
										<p class="large-text"><?php echo $upload_speed; ?> <span class="small-text">Mbps<span></p>
										<?php else: ?>
										<p class="small-text"><?php echo $default_na_text; ?></p>
										<?php endif; ?>
									</div>
								</div>
								<div class="data-point">
									<div class="data-container">
										<div class="label">Contract Length</div><br/>
										<?php if($contract): ?>
											<p class="large-text"><?php echo $contract; ?> <span class="small-text"><?php echo $unit ?><span></p>
                                        <?php else: ?>
                                            <p class="small-text"><?php echo $default_na_text ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						
							<div class="provider_box plan_link <?php echo $cta_count ?>">
								<div>
									<a href="<?php echo $cta_arr['cta_link']; ?>" class="cta_btn" <?php echo $cta_arr['target']; ?> onClick="<?php echo $zipSearchInternetOutboundClick ?>"><?php echo $cta_arr['cta_text']; ?></a>
								</div>
								<div class="phone-container">	
									<?php if ($cta_arr['cta_link2']): ?>
										<?php if ($cta_arr['cta_type2'] == 'call_center'): ?>
											<div class="call-order">Call to Order</div>
										<?php endif; ?>	
										<a href="<?php echo $cta_arr['cta_link2']; ?>" class="cta_btn cta-tel" <?php echo $cta_arr['target2']; ?> onClick="<?php echo $zipSearchInternetOutboundClick2 ?>"><?php echo $cta_arr['cta_text2']; ?></a>
									<?php endif; ?>
								</div>

							</div>
						</div>

						<div class="provider_box provider-more-info">
							<div id="collapse<?php echo $counter ?>" class="collapse collapse-box <?php echo ($zip_qual)?'show':''; ?>" aria-labelledby="heading<?php echo $counter ?>" data-parent="#accordion">
								<div class="collapsed-container">
									<ul class="nav nav-tabs" id="providerTab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="plan-highlights-tab" data-toggle="tab" href="#plan-highlights<?php echo $counter ?>" role="tab" aria-controls="plan-highlights" aria-selected="true">Plan Highlights</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="terms-conditions-tab" data-toggle="tab" href="#terms-conditions<?php echo $counter ?>" role="tab" aria-controls="terms-conditions" aria-selected="false">Terms & Conditions</a>
										</li>
										</ul>
										<div class="tab-content" id="providerTabContent">
										<div class="tab-pane fade active show plan-highlights" id="plan-highlights<?php echo $counter ?>" role="tabpanel" aria-labelledby="plan-highlights-tab">

											<?php if (is_array($internet_plan_highlights)) : ?>
												<ul>
													<?php foreach($internet_plan_highlights as $highlight) : ?>
														<li>
															<div class="icon-container">
																<img src="<?php echo $check ?>" alt="check icon" height="16" width="16">
															</div>
															<div><?php echo $highlight['feature']; ?></div>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
										</div>
										<div class="tab-pane fade terms-conditions" id="terms-conditions<?php echo $counter ?>" role="tabpanel" aria-labelledby="terms-conditions-tab"><?php echo $internet_terms_conditions; ?></div>
								
									</div>
								</div> 
							</div>
								
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $counter ?>" aria-expanded="true" aria-controls="collapse<?php echo $counter ?>">
								<div>
									<div class="detail-text">View Details</div>
									<span class="material-icons">expand_less</span>
								</div>
							</button>
								
						</div>
					</div>
				</div>
				<?php 
				$counter ++;
				endforeach;
	                                        
	        //dataLayer info    
	           $zipSearchDataInternetWrapper = dataLayerProductImpressionWrapperWZipCode($zipcode, $zipSearchInternet);


	        echo "<script> function zipSearchDataInternetWrapper() {dataLayer.push({ ecommerce: null }); ".$zipSearchDataInternetWrapper ."  } </script>";
			endif;
		if (count($results_arr['internet']) > 2){ ?>
			<div class='d-flex justify-content-center'>
				<a href="#" class="cta_btn btn-outline btn-blue see-more-providers">View More</a>
			</div>
		<?php } ?>
	</div>

	<div class="tab-pane fade tv-search <?php echo $tv_active.' '.$tv_show; ?>" id="tv-search" role="tabpanel" aria-labelledby="tv-search-tab">
    	<?php 
    	if (empty($results_arr['tv'])): ?>
			<div class="container">
				<h2 class="no-results-header">No Results found for "<?php echo $no_results; ?>"</h2>
				<p class="demote"> Try searching again using different service type or zip code. </p>
			</div>
              <script> function zipSearchDataTVWrapper() { } </script>
			<?php 
		else:
			foreach($results_arr['tv'] as $key => $provider): 

				$hide_class = '';
				//add class to third+ items
				if ($key > 1){
					$hide_class = 'provider-hidden';
				}

				$logo_id = get_post_meta($provider['id'], 'logo', true);
				$logo = wp_get_attachment_image($logo_id, 'medium');
				$channels = $provider['channels'];
				$tv_info = get_field('tv', $provider['id']);
                $has_plans = get_field('show_plans_page', $provider['id']);
                $cta_count = 'cta-1';
				$cta_arr = get_ctas($provider['id']);

				if (isset($cta_arr['cta_link2'])){
					$cta_count = 'cta-2';
				}
                
                $counterTV++;

                $zipSearchTVVariant['text'] = '';
  
                $zipSearchTVIndv = zipSearchLoadIndv($provider, $zipSearchTVVariant, $counterTV, "TV");
    
                $zipSearchTV .= $zipSearchTVIndv; 
        
                $zipSearchTVProdClick = zipSearchProdClick($zipcode, $provider, $zipSearchTVVariant, $counterTV, "TV");
                
                $zipSearchTVOutboundClick = dataLayerOutboundLinkClick( $provider['id'], "TV", $cta_arr['cta_link'] );

                if ($cta_arr['cta_link2']){
        			$zipSearchTVOutboundClick2 = dataLayerOutboundLinkClick( $provider['id'], "TV", $cta_arr['cta_link2'] );
        		}
                
                
                
				?>
			<div class="container zip-container mb-4 <?php echo $hide_class; ?>" data-channel="<?php echo $channels ?>" data-cost="<?php echo $provider['cost'] ?>">
				<div class="provider-box-row">
					<div class="provider_box img-box">
						<div class="img-wrap">
							<a href="<?php echo get_permalink($provider['id']); ?>" onClick="<?php echo $zipSearchTVProdClick ?>">
								<?php echo $logo;  ?>
							</a>
							<?php if($has_plans) : ?>
                                <div class="view-plan-info">
                                    <a href="/providers/<?php echo strtolower($provider['name']); ?>?plans=show">View plan information</a>
                                </div>
							<?php endif; ?>
						</div>
					</div>
					<div class="right-content">

						<div class="data-points data-count-2">
							<div class="data-point">
								<div class="data-container">
									<div class="label">Channels</div><br/>
									<?php if($channels != 'N/A'): ?>
									<p class="large-text"><?php echo $channels; ?></p>
									<?php else: ?>
									<p class="large-text"><?php echo $channels; ?></p>
									<?php endif; ?>
								</div>
							</div>
							<div class="data-point">
								<div class="data-container">
									<div class="label">Max Upload</div><br/>
									<?php if($upload_speed != 'N/A'): ?>
									<p class="large-text"><?php echo $upload_speed; ?> <span class="small-text">Mbps<span></p>
									<?php else: ?>
									<p class="large-text"><?php echo $upload_speed; ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					
						<div class="provider_box plan_link <?php echo $cta_count ?>">

							<div>
								<a href="<?php echo $cta_arr['cta_link']; ?>" class="cta_btn" <?php echo $cta_arr['target']; ?> onClick="<?php echo $zipSearchTVOutboundClick ?>"><?php echo $cta_arr['cta_text']; ?></a>
							</div>
							<div class="phone-container">	
								<?php if ($cta_arr['cta_link2']): ?>
									<?php if ($cta_arr['cta_type2'] == 'call_center'): ?>
										<div class="call-order">Call to Order</div>
									<?php endif; ?>	
									<a href="<?php echo $cta_arr['cta_link2']; ?>" class="cta_btn cta-tel" <?php echo $cta_arr['target2']; ?> onClick="<?php echo $zipSearchTVOutboundClick2 ?>"><?php echo $cta_arr['cta_text2']; ?></a>
								<?php endif; ?>
							</div>

						</div>
					</div>

					<div class="provider_box provider-more-info">
							<div id="collapse<?php echo $counter ?>" class="collapse collapse-box <?php echo ($zip_qual)?'show':''; ?>" aria-labelledby="heading<?php echo $counter ?>" data-parent="#accordion">
								<div class="collapsed-container">
									<ul class="nav nav-tabs" id="providerTab" role="tablist">
										<li class="nav-item">
						                  <a class="nav-link active" id="plan-highlights-tab" data-toggle="tab" href="#plan-highlights<?php echo $counter ?>" role="tab" aria-controls="plan-highlights" aria-selected="true">Plan Highlights</a>
						                </li>
						                <li class="nav-item">
						                  <a class="nav-link" id="terms-conditions-tab" data-toggle="tab" href="#terms-conditions<?php echo $counter ?>" role="tab" aria-controls="terms-conditions" aria-selected="false">Terms & Conditions</a>
						                </li>
						              </ul>
						              <div class="tab-content" id="providerTabContent">
						              	<div class="tab-pane fade active show plan-highlights" id="plan-highlights<?php echo $counter ?>" role="tabpanel" aria-labelledby="plan-highlights-tab">
						              		<?php if (is_array($tv_info['plan_highlights'])) : ?>
												<ul>
													<?php foreach($tv_info['plan_highlights'] as $highlight) : ?>
														<li>
														  	<svg xmlns="http://www.w3.org/2000/svg" class="svg-check" viewBox="0 0 20 20" fill="currentColor">
																<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
															</svg>
															<div><?php echo $highlight['feature']; ?></div>
														</li>
													<?php endforeach; ?>
												</ul>
						              		<?php endif; ?>
						              	</div>
						                <div class="tab-pane fade terms-conditions" id="terms-conditions<?php echo $counter ?>" role="tabpanel" aria-labelledby="terms-conditions-tab"><?php echo $tv_info['terms_&_conditions']; ?></div>
					           
					              </div>
					            </div> 
							</div>

							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $counter ?>" aria-expanded="true" aria-controls="collapse<?php echo $counter ?>">
								<div>
									<div class="detail-text">View Details</div>
									<span class="material-icons">expand_less</span>
								</div>
							</button>
							
					</div>
				</div>
			</div>
			<?php 
			$counter ++;
			endforeach; 
                                        
            //dataLayer info    
            $zipSearchDataTVWrapper = dataLayerProductImpressionWrapperWZipCode($zipcode, $zipSearchTV);


        echo "<script> function zipSearchDataTVWrapper() {dataLayer.push({ ecommerce: null }); ".$zipSearchDataTVWrapper ."  } </script>";
                                        
		endif;
		if (count($results_arr['tv']) > 2){ ?>
			<div class='d-flex justify-content-center'>
				<a href="#" class="cta_btn btn-outline btn-blue see-more-providers">View More</a>
			</div>
		<?php } ?>
    </div>

    <div class="tab-pane fade bundle-search <?php echo $bundle_active.' '.$bundle_show; ?>" id="bundle-search" role="tabpanel" aria-labelledby="bundle-search-tab">
    	<?php 
    	if (empty($results_arr['bundles'])): ?>
			<div class="container">
				<h2 class="no-results-header">No Results found for "<?php echo $no_results; ?>"</h2>
				<p class="demote"> Try searching again using different service type or zip code. </p>
			</div>
          <script> function zipSearchDataBundleWrapper() { } </script>
			<?php 
		else:
			foreach($results_arr['bundles'] as $key => $provider):

				$hide_class = '';
				//add class to third+ items
				if ($key > 1){
					$hide_class = 'provider-hidden';
				}

				$logo_id = get_post_meta($provider['id'], 'logo', true);
				$logo = wp_get_attachment_image($logo_id, 'medium');
				$download_speed = $provider['download_speed'];
				$channels = $provider['channels'];
				$bundle_info = get_field('bundles', $provider['id']);
                $has_plans = get_field('show_plans_page', $provider['id']);
                $cta_count = 'cta-1';
				$cta_arr = get_ctas($provider['id']);

				if (isset($cta_arr['cta_link2'])){
					$cta_count = 'cta-2';
				}
                
                $counterBundle++;
  
  				$zipSearchBundleVariant['text'] = '';

                $zipSearchBundleIndv = zipSearchLoadIndv($provider, $zipSearchBundleVariant, $counterBundle, "Bundle");
                    
                $zipSearchBundle .= $zipSearchBundleIndv;  
        
                $zipSearchBundleProdClick = zipSearchProdClick($zipcode, $provider, $zipSearchBundleVariant, $counterBundle, "Bundle");
                
                $zipSearchBundleOutboundClick = dataLayerOutboundLinkClick( $provider['id'], "Bundle", $cta_arr['cta_link'] );

                if ($cta_arr['cta_link2']){
        			$zipSearchBundleOutboundClick2 = dataLayerOutboundLinkClick( $provider['id'], "Bundle", $cta_arr['cta_link2'] );
        		}
        
        
				?>
			<div class="container zip-container mb-4 <?php echo $hide_class; ?>" data-channel="<?php echo $channels ?>" data-download="<?php echo $download_speed ?>" data-cost="<?php echo $provider['cost'] ?>">
				<div class="provider-box-row">
					<div class="provider_box img-box">
						<div class="img-wrap">
							<a href="<?php echo get_permalink($provider['id']); ?>" onClick="<?php echo $zipSearchBundleProdClick ?>">
								<?php echo $logo;  ?>
							</a>
							<?php if($has_plans) : ?>
                                <div class="view-plan-info">
                                    <a href="/providers/<?php echo strtolower($provider['name']); ?>?plans=show">View plan information</a>
                                </div>
							<?php endif; ?>
						</div>
					</div>
					<div class="right-content">

						<div class="data-points data-count-2">
							<div class="data-point">
								<div class="data-container">
									<div class="label">Download Speed</div><br/>
									<?php if($download_speed != 'N/A'): ?>
									<p class="large-text"><?php echo $download_speed; ?> <span class="small-text">Mbps<span></p>
									<?php else: ?>
									<p class="large-text"><?php echo $download_speed; ?></p>
									<?php endif; ?>
								</div>
							</div>
							<!-- <div class="data-point">
								<div class="data-container">
									<div class="label">Starting at</div><br/>
									<?php if($provider['cost'] != 'N/A'): ?>
									<p class="large-text"><?php echo $provider['cost']; ?></p>
									<?php else: ?>
									<p class="large-text"><?php echo $provider['cost']; ?></p>
									<?php endif; ?>
								</div>
							</div> -->
							<div class="data-point">
								<div class="data-container">
									<div class="label">Channels</div><br/>
									<?php if($channels != 'N/A'): ?>
									<p class="large-text"><?php echo $channels; ?> <span class="small-text">mo.<span></p>
									<?php else: ?>
									<p class="large-text"><?php echo $channels; ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="provider_box plan_link <?php echo $cta_count ?>">
							<div>
								<a href="<?php echo $cta_arr['cta_link']; ?>" class="cta_btn" <?php echo $cta_arr['target']; ?> onClick="<?php echo $zipSearchBundleOutboundClick ?>"><?php echo $cta_arr['cta_text']; ?></a>
							</div>
							<div class="phone-container">	
								<?php if ($cta_arr['cta_link2']): ?>
									<?php if ($cta_arr['cta_type2'] == 'call_center'): ?>
										<div class="call-order">Call to Order</div>
									<?php endif; ?>	
									<a href="<?php echo $cta_arr['cta_link2']; ?>" class="cta_btn cta-tel" <?php echo $cta_arr['target2']; ?> onClick="<?php echo $zipSearchBundleOutboundClick2 ?>"><?php echo $cta_arr['cta_text2']; ?></a>
								<?php endif; ?>
							</div>

						</div>
					</div>

					<div class="provider_box provider-more-info">
						<div id="collapse<?php echo $counter ?>" class="collapse collapse-box <?php echo ($zip_qual)?'show':''; ?>" aria-labelledby="heading<?php echo $counter ?>" data-parent="#accordion">
							<div class="collapsed-container">
								<ul class="nav nav-tabs" id="providerTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="plan-highlights-tab" data-toggle="tab" href="#plan-highlights<?php echo $counter ?>" role="tab" aria-controls="plan-highlights" aria-selected="true">Plan Highlights</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="terms-conditions-tab" data-toggle="tab" href="#terms-conditions<?php echo $counter ?>" role="tab" aria-controls="terms-conditions" aria-selected="false">Terms & Conditions</a>
									</li>
									</ul>
									<div class="tab-content" id="providerTabContent">
									<div class="tab-pane fade active show plan-highlights" id="plan-highlights<?php echo $counter ?>" role="tabpanel" aria-labelledby="plan-highlights-tab">

										<?php if (is_array($bundle_info['plan_highlights'])) : ?>
											<ul>
												<?php foreach($bundle_info['plan_highlights'] as $highlight) : ?>
													<li>
														<svg xmlns="http://www.w3.org/2000/svg" class="svg-check" viewBox="0 0 20 20" fill="currentColor">
															<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
														</svg>
														<div><?php echo $highlight['feature']; ?></div>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</div>
									<div class="tab-pane fade terms-conditions" id="terms-conditions<?php echo $counter ?>" role="tabpanel" aria-labelledby="terms-conditions-tab"><?php echo $bundle_info['terms_&_conditions']; ?></div>
							
								</div>
							</div> 
						</div>
						
						<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $counter ?>" aria-expanded="true" aria-controls="collapse<?php echo $counter ?>">
							<div>
								<div class="detail-text">View Details</div>
								<span class="material-icons">expand_less</span>
							</div>
						</button>
							
					</div>
				</div>
			</div>
			<?php 
			$counter ++;
			endforeach; 
            
            //dataLayer info  
             $zipSearchDataBundleWrapper = dataLayerProductImpressionWrapperWZipCode($zipcode, $zipSearchBundle);



        echo "<script> function zipSearchDataBundleWrapper() { dataLayer.push({ ecommerce: null });  ".$zipSearchDataBundleWrapper ."   } </script>";
                                        
		endif;
		if (count($results_arr['bundles']) > 2){ ?>
			<div class='d-flex justify-content-center'>
				<a href="#" class="cta_btn btn-outline btn-blue see-more-providers">View More</a>
			</div>
		<?php } ?>
    </div>
</div>

<?php 
if ($type == 'internet'){
	echo "<script> zipSearchDataInternetWrapper(); </script>";
} elseif($type == 'tv'){
	echo "<script> zipSearchDataTVWrapper(); </script>";
} elseif ($type == 'bundle'){
    echo "<script> zipSearchDataBundleWrapper(); </script>";
}

?>