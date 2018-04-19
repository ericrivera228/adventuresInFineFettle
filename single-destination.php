<!DOCTYPE html>

<html>

	<?php get_header(); ?>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<div class="destinationPosts">


				<?php

					//Grab all posts that pertain to this destination
					$args = array(
						'orderby' => 'post_date', 
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'destination', 
								'value' => get_the_ID(),
								'compare' => '='
							)
						)
					);

					$destinationPosts = get_posts( $args );

					//The horizontalPost template requires the '$postImage' to know what field to get the image from. 
					$imageFieldName = "post_image";

					//Render out each post
					foreach( $destinationPosts as $post ){

						$postExcerpt = $post->post_excerpt;
						$postContent = $post->post_content;

						include( locate_template( 'web_library/web_components/horizontalPost.php', false, false ) );
					}
					
					wp_reset_query();

				?>

			</div>

			<?php

				//The below imports of the item box template require the $imageFieldName to be supplied; which for all the places is 'place_image'.
				$imageFieldName = 'place_image';

				$sectionClass = 'restaurantSection';
				$itemBoxTitle = 'Restaurants';
				$items = getPlacesByType('restaurant');
				include( locate_template( 'web_library/web_components/itemBox.php', false, false ) );

			?>

			<?php

				$sectionClass = 'thingsToDoSection';
				$itemBoxTitle = 'Things To Do';
				$items = getPlacesByType('things-to-do');
				include( locate_template( 'web_library/web_components/itemBox.php', false, false ) );

			?>

			<?php

				$sectionClass = 'hotelsSection';
				$itemBoxTitle = 'Where To Stay';
				$items = getPlacesByType('where-to-stay');
				include( locate_template( 'web_library/web_components/itemBox.php', false, false ) );

			?>

			<?php 

				$safteyConcerns = get_field("safety_concerns", get_the_ID());

				if(isStringNullOrWhiteSpace($safteyConcerns) != true):
			?>

				<div class="safteyConcernsContainer">

					<h3>
						<i class="fa fa-medkit"></i> Health	&amp; Safety Tips
					</h3>

					<div class="fadeRightLine"></div>

					<div class="saftetyConcernsTextWrapper">

						<?php echo $safteyConcerns; ?>

						<div>

							&nbsp;
							&nbsp;

							<p class="safety-disclaimer">
								The purpose of this website is to inspire health conscious travel.  The information is in no way intended to diagnose or treat illness and should not be used as a substitute for seeing your healthcare provider.
							</p>

						</div>

					</div>

				</div>

			<?php endif; ?>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>

<?php

	//Create array of arguments to run a query that gets all the places of the specified place type for this destination
	function getPlacesByType($placeTypeTaxonomySlug){

		$args = array(
			'orderby' => 'post_date', 
			'order' => 'DESC',
			'post_type' => 'place',
			'numberposts'=>-1,
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

		return get_posts( $args );

	}

?>