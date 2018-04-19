<?php $singleColumn = false; ?> 

<div class="horizontalPost <?php if(!(isset($isTeamMemberPost) && $isTeamMemberPost === true)) echo 'bounceBox';?>" data-original-post-orientation="horizontal">

	<?php if(!(isset($isTeamMemberPost) && $isTeamMemberPost === true)): ?>

		<a href = <?php echo get_permalink($post->ID); ?>>

	<?php endif;?>

		<?php 
			$postImage = get_field($imageFieldName, $post->ID);	
			if($postImage != null): 
		?>

			<div class='hacky-flexbox-fixer'>

				<?php renderImgElement($postImage, "cover"); ?>	

			</div>

		<?php else :?>

			<?php $singleColumn = true; ?>

		<?php endif;?>

		<div class="flexContainer <?php if($singleColumn == true) echo ' singleColumn'; ?>">

			<div class="horizontalPostTextWrapper <?php if($singleColumn == true) echo 'singleColumn'; ?>" >

				<h3>
					<?php echo $post->post_title ?>
				</h3>

				<div class="fadeRightLine"></div>

				<div class="horizontalClampParagraph">

					<p class='clampParagraph'>

						<?php

							//If a post excerpt exists, display that. Otherwise, display the post content.
							if(isset($postExcerpt) && isStringNullOrWhiteSpace($postExcerpt) != true){
								echo $postExcerpt;
							}
							else if(isStringNullOrWhiteSpace($postContent) != true){
								echo wp_strip_all_tags($postContent, true);
							} 

						?>

					</p>

				</div>

			</div>

			<?php

				if(!(isset($isTeamMemberPost) && $isTeamMemberPost === true)):

			?>

				<div class = "horizontalPostTextFooter">

					<p>
						Read More <i class="fa fa-chevron-right" aria-hidden="true"></i>
					</p>

				</div>

			<?php endif;?>

		</div>

	<?php if(!(isset($isTeamMemberPost) && $isTeamMemberPost === true)): ?>

		</a>

	<?php endif;?>

</div>

<div style="clear:both"></div>
