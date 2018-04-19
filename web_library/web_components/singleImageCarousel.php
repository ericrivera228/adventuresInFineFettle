<div class="slick-single-image-carousel-wrapper placeDataGroup">

	<div class="carouselButtonPrevious">
		<i class="fa fa-chevron-left" aria-hidden="true""></i>
	</div>

		<div class="slick-single-image-carousel">

			<?php

				foreach ($galleryImages as $image):

					$imageUrl = ($image != null) ? $image['url'] : "";
					$imageCaption = ($image != null) ? $image['caption'] : "";

			?>

				<div class="carouselColumn">

						<div class="expand-overlay">

							<a data-lightbox="placeGallery" 
								<?php echo isStringNullOrWhiteSpace($imageCaption) != true ? "data-title='".$imageCaption."'" : ""; ?> 
								<?php echo isStringNullOrWhiteSpace($imageUrl) != true ? "href='".$imageUrl."'" : ""; ?>
							>
								<i class="fa fa-search-plus" aria-hidden="true"></i>
							</a>

						</div>
					
					<?php renderImgElement($image, "cover", true); ?>

				</div>

			<?php endforeach; ?>												

		</div>

	<div class="carouselButtonNext">
		<i class="fa fa-chevron-right" aria-hidden="true"></i>
	</div>

</div>