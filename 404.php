<!DOCTYPE html>

<html>

	<?php get_header(); ?>

	<body>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<p class="message-404">
				Oops! Something went wrong; it looks like the page you are looking for doesn't exist. Click <a href="<?php echo get_home_url(); ?>">here</a> to go back to the main site.
			</p>
			

		</div>

		<?php get_footer(); ?>

	</body>	

</html>