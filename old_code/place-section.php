<?php

	//Renders a place section of the specified type.
	//Requires 3 parameters to be set:
	//$sectionClass: Class that gets applied to the wrapper div of this section
	//$placeTypeTaxonomySlug: Taxonomy slug to query places by
	//$placeTypeTitle: <h3> text that appears in the header of the section.

	//Grab all the places of the specified place type for this destination
	$args = array(
		'orderby' => 'post_date', 
		'order' => 'DESC',
		'post_type' => 'place',
		'meta_query' => array(
			array(
				'key' => 'destination', 
				'value' => get_the_ID(),
				'compare' => '='
			)
		),
		'tax_query' => array(
			array(
				'taxonomy' => 'place_type',
				'field' => 'slug',
				'terms' => $placeTypeTaxonomySlug
			)
		)
	);

	$places = get_posts( $args );
	$placesCount = count($places)

?>

<?php 

	//If there is at least one place tied to this destination, display the place box
	if($placesCount > 0): 

?>

	<div class="<?php echo $sectionClass; ?>">

		<div class = "itemBox">

			<h3>
				<?php echo $placeTypeTitle; ?>
			</h3>

			<div class="fadeRightLine"></div>

			<div class="itemBox-items <?php if($placesCount === 1) echo 'oneColumnBox'; else if($placesCount === 2) echo 'twoColumnBox';?>">

				<?php 

					foreach ($places as $place): 

						$placeImage = get_field("place_image", $place->ID);	
						$placeImageUrl = $placeImage['url'];
						$placeImageAlt = $placeImage['alt'];

				?>

					<div class="itemBox-item bounceBox">

						<a href = <?php echo get_permalink($place->ID); ?>>

							<img class="cover" src="<?php echo $placeImageUrl; ?>" <?php if(isStringNullOrWhiteSpace($placeImageAlt) != true) echo 'alt="'.$placeImageAlt.'"'; ?>">

							<p><?php echo $place->post_title; ?></p>

						</a>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	</div>

<?php endif; ?>