<div class = "blogHeader">

	<div id="bannerCarousel" class="carousel">
		<div class="carousel-inner">
			<div class="item active">

				<img src="<?php echo get_bloginfo('template_url') ?>/img/SliderPictures/bora bora.bmp" class="bannerPicture">

				<!--Need to put the caption box in two wrappers so that it can be oriented from the bottom right corner of the picture -->
				<div id="bannerCaptionWrapperLevel1">
					<div id="bannerCaptionWrapperLevel2">

						<div id="bannerCaption">

							<p id="bannerImageDescription">
								This is some description for the Bora Bora pictccatbarure. It will saying something cool and intersting about Bora Bora...
							</p>

							<p id="bannerImageLinks">
								<a href="#">Read More</a>
								|
								<a href="#">Next </a> 
							</p>	

						</div>

					</div>
				</div>

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
	        <li class="nav-item"><a href="#" class="nav-link">Upcoming Travel</a></li>
	        <li><a href="<?php echo get_site_url(); ?>/team-members">Meet the Team</a></li>
	        <li><a href="#">Contact Us</a></li>
	      </ul>

	    </div><!-- /.navbar-collapse -->

	  </div><!-- /.container-fluid -->
	</nav>

</div>