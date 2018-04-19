<div class="destinationSectionWrapper">

<?php 

	$regions = getAllRegions();

	//For each region, render out the carusel
	foreach ($regions as $region): 

		$destinations = getDestinationsByRegion($region);

		$caruselWrapperClass = "carouselWrapperNoArrows";

		if(count($destinations) > 3){
			$caruselWrapperClass = "carouselWrapperArrows";	
		}

?>

		<div class="carouselContainer">

			<h3><?= $region->name; ?></h3>

			<div class="carouselColumnsWrapper">

				<div class="carouselArrowColumn carouselButtonPrevious">
					<i class="fa fa-chevron-left" aria-hidden="true""></i>
				</div>


				<div class="<?php echo $caruselWrapperClass ?>">

					<div class="slick-carousel">

						<?php 

							//Create a column for each destination
							foreach ($destinations as $destination): 

								$destinationImage = get_field("destination_image", $destination->ID);	
								$destinationImageUrl = $destinationImage['url'];
								$destinationImageAlt = $destinationImage['alt'];

						?>

								<div class="carouselColumn bounceBox">

									<a href = <?php echo get_permalink($destination->ID); ?>>

										<?php

											//If a post image was found, render it.
											if($destinationImage != null){

												echo '<img data-lazy="'.$destinationImageUrl.'" class="cover"';

												if(isStringNullOrWhiteSpace($destinationImageAlt) != true)
												{
													echo 'alt="'.$destinationImageAlt.'"';
												}

												echo '>';

											}

										?>

										<p><?= $destination->post_title ?></p>

									</a>

								</div>

						<?php endforeach; ?>

					</div>

				</div>

				<div class="carouselArrowColumn carouselButtonNext">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
				</div>

			</div>

		</div>

	<?php endforeach; ?>

</div>