<?php
	$showDestinationBanner = false;
	$destinationName = '';
?>

<div class = "blogHeader">

    <div class="banner-wrapper">

		<div id="slickBannerCarousel">

			<?php



				$postType = get_post_type(get_the_ID());

				if($postType === 'destination' || $postType === 'place' || is_single()):

					$showDestinationBanner = true;
					$destinationBannerImage;

					if($postType === 'destination'){
						$destinationName = get_the_title();
						$destinationBannerImage = get_field('banner_picture', get_the_ID());
					}

					else if($postType === 'place'){
						$destinationName =  get_the_title(get_field('destination', get_the_ID(), false));
						$destinationBannerImage = get_field('banner_picture', get_field('destination', get_the_ID(), false));
					}

					//Posts
					else{


						//First, see if this post has a banner picture.
						$destinationBannerImage = get_field('banner_picture', get_the_ID());

						//If this post does not have a banner picture, grab the banner picture for it's destination
						if(empty($destinationBannerImage)){
							$destinationBannerImage = get_field('banner_picture', get_field('destination', get_the_ID(), false));	
						}
						
					}

			?>
				<div class = "banner-slide">
					<?php renderImgElement($destinationBannerImage, "bannerPicture cover", false); ?>
				</div>

			<?php

					
				else:
					$posts = getLatestPostsWithBannerPicture();

					foreach ($posts as $post):

						$bannerImage = get_field("banner_picture", $post->ID);
						$bannerCaption = get_field("banner_text", $post->ID);
						$postLink = get_permalink($post->ID);

						//If no banner caption is supplied, just use the post title
						if(isStringNullOrWhiteSpace($bannerCaption)){
							$bannerCaption = $post->post_title;
						}

			?>

						<div class = "banner-slide" data-link="<?php echo $postLink; ?>" data-caption="<?php echo $bannerCaption; ?>">

							<?php renderImgElement($bannerImage, "bannerPicture cover", true); ?>

						</div>

					<?php endforeach; ?>
				<?php endif; ?>

	    </div>

	    <div id = "destinationBannerTitleWrapper">

		    <div id="destinationBannerTitle">
		    	<?php echo $destinationName ?>
		    </div>

	    </div>



    	<div id="bannerCaptionBox" class="<?php if($showDestinationBanner) echo 'hidden'; ?>">

			<div id="bannerCaption">

				<p class = "clampParagraph"></p>

			</div>

			<div id="bannerCaptionBoxFooter">

					<a id="bannerPostLink">Read More</a>
					<a id="bannerNextSlide" onClick="onBannerNext()">Next </a> 

			</div>

		</div>

    </div>

    <div id="titleContainerWrapper">

    	<a href="<?php echo get_site_url(); ?>">

		    <div id="titleContainer">

				<span id="titleTop">Adventures</span>
				<span id="titleBottom">In Fine Fettle</span>

			</div>

			<!-- Internet explorer and Firefox don't quit display the shadow on the title box correctly (a 1px gap in betten the box and shadow). This element is used as a background to fill that gap -->
			<div id="backgroundTitleContainer"></div>

    	</a>

    </div>

	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">

	    <div class="navbar-header">

	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>

	    </div>

	    <div class="collapse navbar-collapse">

	      <ul class="nav navbar-nav">
	        <li class="nav-item"><a href="<?php echo get_site_url(); ?>/destinations" class="nav-link">Destinations <span class="sr-only">(current)</span></a></li>
	        <li class="nav-item"><a href="<?php echo get_permalink( get_page_by_title( 'Upcoming Travel' ) ) ?>" class="nav-link">Upcoming Travel</a></li>
	        <li><a href="<?php echo get_site_url(); ?>/team-members">Meet the Team</a></li>
	        <li><a href="<?php echo get_permalink( get_page_by_title( 'Contact Us' ) ) ?>">Contact Us</a></li>
	      </ul>

	    </div><!-- /.navbar-collapse -->

	  </div><!-- /.container-fluid -->
	</nav>

</div>