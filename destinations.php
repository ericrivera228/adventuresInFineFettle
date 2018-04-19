<!DOCTYPE html>

<html>

	<?php /* Template Name: Destinations */ ?>

	<?php get_header(); ?>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<?php 

				//The below imports of the item box template require the $imageFieldName to be supplied; which for all the destionations is 'destination_image'.
				$imageFieldName = 'destination_image';

				$regions = getAllRegions();

					//For each region, render out the carusel
					foreach ($regions as $region) 
					{

						//Grab all the destinations in this region (naming $items because that is what the item box templace requires.)
						$items = getDestinationsByRegion($region);
						$sectionClass = $region->name.'ItemBox';
						$itemBoxTitle = $region->name;
						include(locate_template('web_library/web_components/itemBox.php'));

					}

			?>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>