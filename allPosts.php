<!DOCTYPE html>

<html>

	<?php /* Template Name: All Posts */ ?>

	<?php get_header(); ?>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<div class="allPostsWrapper">
				
				<?php

					//Grab all the posts
					$args = array('orderby' => 'post_date', 'order' => 'DESC', 'post_status' => 'publish', 'post_type' => 'post', 'posts_per_page' => -1);
					$recent_posts = wp_get_recent_posts( $args );

					//Render out each post
					foreach( $recent_posts as $post ){
						get_template_part('web_library/web_components/verticalPost');
					}
					
					wp_reset_query();
				?>
							
				<!-- Needed to ensure the wrappers wrap around their children -->
				<div style="clear:both"></div>

			

			</div>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>