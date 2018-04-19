<?php 

	//$items
	//$sectionClass
	//$imageFieldName
	//$itemBoxTitle

	$itemsCount = count($items);

	//If there is at least one item to be shown, display the place box
	if($itemsCount > 0): 

?>

	<div class="<?php echo $sectionClass; ?>">

		<div class = "itemBox">

			<h3>
				<?php echo $itemBoxTitle; ?>
			</h3>

			<div class="fadeRightLine"></div>

			<div class="itemBox-items <?php if($itemsCount === 1) echo 'oneColumnBox'; else if($itemsCount === 2) echo 'twoColumnBox';?>">

				<?php 

					foreach ($items as $item): 

						$itemImage = get_field($imageFieldName, $item->ID);	
						$itemImageUrl = $itemImage['url'];
						$itemImageAlt = $itemImage['alt'];

				?>

					<div class="itemBox-item bounceBox">

						<a href = <?php echo get_permalink($item->ID); ?>>

							<img class="cover" src="<?php echo $itemImageUrl; ?>" <?php if(isStringNullOrWhiteSpace($itemImageAlt) != true) echo 'alt="'.$itemImageAlt.'"'; ?>">

							<p><?php echo $item->post_title; ?></p>

						</a>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	</div>

<?php endif; ?>