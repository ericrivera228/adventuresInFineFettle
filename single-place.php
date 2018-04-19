<!DOCTYPE html>

<html>

	<?php get_header(); ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXL08t8b84vaMnb1D0X4Q0vga0JH-EgGA"></script>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<div class="postWrapper">

				<div class="postHeader">

					<h1> 
						<?php 

							if($wp_query->post->post_title && isStringNullOrWhiteSpace($wp_query->post->post_title) !== true){
								echo ($wp_query->post->post_title);		
							}
						
						?> 
					</h1>

				</div>

				<div class="placeContentWrapper">

					<?php

						$leftColumnClass = "placeColumnWrapper";
						$address = get_field("address", get_the_ID());
						$website = get_field("website", get_the_ID());
						$info = get_field("info", get_the_ID());
						$location = get_field('location', get_the_ID());

						if(isStringNullOrWhiteSpace($address) && isStringNullOrWhiteSpace($website) && isStringNullOrWhiteSpace($info) && empty($location)){
							$leftColumnClass = "singlePlaceColumnWrapper";
						}

					?>

					<div class="<?php echo $leftColumnClass; ?>">

						<div class="placeColumn">

							<div class="postContent placeDataGroup">

								<?php echo get_field("description", get_the_ID()); ?>

							</div>

							<?php 

								$galleryImages = get_field("image_gallery", get_the_ID());

								if(count($galleryImages) > 0){
									include( locate_template( '/web_library/web_components/singleImageCarousel.php', false, false ) );
								}

							?>

						</div>
						
					</div>

					<?php

						if(!isStringNullOrWhiteSpace($address) || !isStringNullOrWhiteSpace($website) || !isStringNullOrWhiteSpace($info) || !empty($location)):

					?>

						<div class="placeColumnWrapper">

							<div class="placeColumn">

								<?php 

									if(!isStringNullOrWhiteSpace($address)):

								?>

									<div class="placeDataGroup">

										<div>
											<i class="fa fa-map-marker" aria-hidden="true"></i>
										</div>

										<div>
											<span><?php echo $address; ?></span>
										</div>

									</div>

								<?php endif; ?>			
								
								<?php

									if(!isStringNullOrWhiteSpace($website)):

								?>					

									<div class="placeDataGroup">

										<div>
											<i class="fa fa-desktop" aria-hidden="true"></i>
										</div>

										<div>
											<a href="<?php echo $website ?>">Visit Site</a>
										</div>

									</div>

								<?php endif; ?>

								<?php 

									if(!isStringNullOrWhiteSpace($info)):

								?>

									<div class="placeDataGroup placeInfoData">

										<div>
											<i class="fa fa-info-circle" aria-hidden="true"></i>
										</div>

										<div>
											<p><?php echo $info; ?></p>
										</div>

									</div>

								<?php endif; ?>

								<?php 
			
									if(!empty($location)):

								?>

									<div class="placeDataGroup">

										<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBXL08t8b84vaMnb1D0X4Q0vga0JH-EgGA&q=<?php echo urlencode($location['address']); ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

									</div>

								<?php endif; ?>

							</div>

						</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>
