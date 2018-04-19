<!DOCTYPE html>

<html>

	<?php /* Template Name: Team Members */ ?>

	<?php get_header(); ?>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper teamMemberWrapper">

			<?php 

				$teamMembers = getAllTeamMembers();

				//The horizontalPost template requires the '$postImage' to know what field to get the 	image from. 
				$imageFieldName = "picture";

				//Each team member box is just a special kind of horizontal post; let the template know it needs to create a team member post.
				$isTeamMemberPost = true;

				foreach ($teamMembers as $post): 

					$postContent = get_field("description", $post -> ID);

					include( locate_template( 'web_library/web_components/horizontalPost.php', false, false ) );
				
			?>

			<?php endforeach; ?>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>