<div class="verticalPostWrapper">

		<div class="verticalPost bounceBox">

			<a href= <?php echo get_permalink($post["ID"]); ?>>

				<div class='hacky-flexbox-fixer'>

					<?php
				
						$postImage = get_field("post_image", $post['ID']);

						if($postImage != null){
							renderImgElement($postImage, 'cover');
						}

					?>

				</div>



				<div class = "verticalPostContentWrapper">

					<h3>
						<?php 
							if(isStringNullOrWhiteSpace($post["post_title"]) !== true){
								echo $post["post_title"];
							} 
						?>
					</h3>

					<p class="clampParagraph">

						<?php

							//If a post excerpt exists, display that. Otherwise, display the post content.
							if(isStringNullOrWhiteSpace($post["post_excerpt"]) != true){
								echo $post["post_excerpt"];
							}
							else if(isStringNullOrWhiteSpace($post["post_content"]) != true){
								echo wp_strip_all_tags($post["post_content"], true);
							} 

						?>

					</p>

				</div>

				<div class = "verticalPostContentFooter">

					<p>
						Read More <i class="fa fa-chevron-right" aria-hidden="true"></i>
					</p>

				</div>


			</a>

		</div>

		<div style="clear:both"></div>

</div>