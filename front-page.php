<!DOCTYPE html>

<html>

	<?php get_header(); ?>

	<body>

		<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
		<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';}(jQuery));var $mcj = jQuery.noConflict(true)</script>

		<?php get_template_part('web_library/page_sections/site', 'header');?>

		<div class="contentWrapper">

			<?php get_template_part('web_library/page_sections/latestPosts'); ?>

		</div>

		<div class="fadingLine"></div>

		<div class="contentWrapper">

			<?php get_template_part( 'web_library/page_sections/destinationsSection'); ?>

		</div>

		<div class="email-footer">

			<button type="button" class="close" aria-label="Close" onClick="closeEmailBar()">
				<span aria-hidden="true">&times;</span>
	        </button>


			<div class="contentWrapper">

        		<div id="mc_embed_signup">

					<form action="//adventuresinfinefettle.us15.list-manage.com/subscribe/post?u=43eb2293b359096d0ca4b5ba3&amp;id=2138d1389d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    
					    <div id="mc_embed_signup_scroll">
							<p>Get the latest Adventures in Fine Fettle posts delivered to your inbox!</p>
							
							<div class="mc-field-group">
						
								<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email">
								<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">

							</div>

							<div id="mce-responses" class="clear">
								
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
					
							</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				    	
				    		<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d9db7601184b0bb481b986f72_a04e10758a" tabindex="-1" value=""></div>

			    		</div>
					</form>
				</div>

			</div>

		</div>

		<?php get_footer(); ?>

	</body>	

</html>