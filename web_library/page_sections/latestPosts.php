<div class="latestPostsWrapper">
	
	<?php

		//Grab the 3 newest psots
		$args = array( 'numberposts' => '3', 'orderby' => 'post_date', 'order' => 'DESC', 'post_type' => 'post');
		$recent_posts = wp_get_recent_posts( $args );

		//Render out each post
		foreach( $recent_posts as $post ){
			get_template_part( 'web_library/web_components/verticalPost'); 
		}
		
		wp_reset_query();
	?>
				
	

</div>

<div class="contentLink">
	<a href="<?php echo getPagePermalinkByPageName('All Posts'); ?>" class="latestPostLink">View all posts</a>
</div>