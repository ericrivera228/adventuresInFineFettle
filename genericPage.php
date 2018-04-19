<!DOCTYPE html>

<html>

	<?php /* Template Name: Generic Page */ ?>

	<?php get_header(); ?>

	<body class="post-body">

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

				<div class="postContent">
					<?php 

						if($wp_query->post->post_content && isStringNullOrWhiteSpace($wp_query->post->post_content) !== true){
							echo wpautop(($wp_query->post->post_content), true);
						} 

					?>
				</div>

			</div>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>