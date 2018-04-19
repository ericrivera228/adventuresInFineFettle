var carouselBreakpointTwoColumn = 1616;
var carouselBreakpointOneColumn = 825;
var horizontalPostsConvertedToVertical = false;
var emailBarSlideSpeed = 500;

//The window width at which horizontal posts are converted to vertical posts
var horizontalPostWidthLimit = 767;

//Reference to the timeout event for triggering the banner to rotate
var timeout;

// Opera 8.0+
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

// Firefox 1.0+
var isFirefox = typeof InstallTrigger !== 'undefined';

// Safari 3.0+ "[object HTMLElementConstructor]" 
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

// Internet Explorer 6-11
var isIE = /*@cc_on!@*/false || !!document.documentMode;

// Edge 20+
var isEdge = !isIE && !!window.StyleMedia;

// Chrome 1+
var isChrome = !!window.chrome && !!window.chrome.webstore;

// Blink engine detection
var isBlink = (isChrome || isOpera) && !!window.CSS;

$(window).bind('load', function() {

	//Need to call this method on initial page load because the server does not know how big the browser window is; it assumes 
	//the window is large which could be incorrect.
	updatePageOnResize();

	//There can be an ever-so-slight delay in the time the page loads and the initial javascript completes running. So the body is set
	//to hidden by default, and then shown once the page load processing is all done.
	$('body').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}, 200);

});

$(window).resize(function () {
	updatePageOnResize();
});


//Does all the necessary tasks when when the browser window is resized.
function updatePageOnResize(){

	configureHorizontalPostsOnResize();
	updatePostContentHeight();
	updateCarouselWrappers();
	fixHackyFlexbox();
}

function clampBannerCaption(){

	$('#bannerCaptionBox .clampParagraph').each(function(index, item) {

		//Get the line height of the caption
		var lineHeight = convertElementAttributeValueToNumber(this, "line-height");
		var height = $(this).height();

		if(height > (lineHeight * 3)){
			$clamp(item, {clamp: '3', useNativeClamp: false});
		}

	});

}

function updatePostContentHeight(){

	$('.verticalPost .verticalPostContentWrapper').each(function(){

		var postHeader = $(this).find('h3');
		var postContent = $(this).find('p');
		var img = $(this).prev('div');
		var footer = $(this).next('.verticalPostContentFooter');

		var headerHeight = 0;
		var imgHeight = 0;
		var footerHeight = 0;
		var verticalPostHeight = $(this).parent().height();

		if(!isObjectEmpty(img)){
			imgHeight = getTotalHeightOfElement(img);
		}

		if(!isObjectEmpty(postHeader)){
			headerHeight = getTotalHeightOfElement(postHeader);
		}


		if(!isObjectEmpty(footer)){
			footerHeight = getTotalHeightOfElement(footer);
		}

		availableHeight = verticalPostHeight - headerHeight - imgHeight - footerHeight;

		//Only clamp if the content height is greater than the available:
		if(getTotalHeightOfElement(postContent) > availableHeight){

			//Make the paragraph height such that it breaks evenly on a text line
			$(this).find('.clampParagraph').each(function(index, item) {
	    		$clamp(item, {clamp: availableHeight + 'px', useNativeClamp: false});
			});

		}

	});

	$('div:not(.teamMemberWrapper) .horizontalPost .flexContainer').each(function(){

		var postHeader = $(this).find('h3');
		var lineDivider = $(this).find('.fadeRightLine');
		var postContent = $(this).find('.horizontalClampParagraph');
		var postFooter = $(this).find('.horizontalPostTextFooter');
		var textWrapper = $(this).find('.horizontalPostTextWrapper');

		var headerHeight = 0;
		var lineDividerHeight = 0;
		var postFooterHeight = 0;
		var textWrapperPadding = 0;

		//Get the height of all the objects that make up the right side of the horizontal post
		if(!isObjectEmpty(postHeader)){
			headerHeight = getTotalHeightOfElement(postHeader);
		}

		if(!isObjectEmpty(lineDivider)){
			lineDividerHeight = getTotalHeightOfElement(lineDivider);
		}

		if(!isObjectEmpty(postFooter)){
			postFooterHeight = getTotalHeightOfElement(postFooter);
		}

		if(!isObjectEmpty(textWrapperPadding)){
			textWrapperPadding = convertElementAttributeValueToNumber(textWrapper, "padding-top");
		}

		var horizontalPostHeight = $(this).height();

		//Calculate how much height is left for the excerpt paragraph
		availableHeight = horizontalPostHeight - textWrapperPadding - headerHeight - lineDividerHeight - postFooterHeight;

		//Only clamp if the content height is greater than the available:
		if(getTotalHeightOfElement(postContent) > availableHeight){

			//Make the paragraph height such that it breaks evenly on a text line
			$(this).find('.clampParagraph').each(function(index, item) {
	    		$clamp(item, {clamp: availableHeight + 'px', useNativeClamp: false});
			});

		}

	});

}

function getTotalHeightOfElement(element){
	return convertElementAttributeValueToNumber(element, "margin-top") + convertElementAttributeValueToNumber(element, "padding-top") + $(element).height() + convertElementAttributeValueToNumber(element, "margin-bottom") + convertElementAttributeValueToNumber(element, "padding-bottom") ;
}

function configureHorizontalPostsOnResize(){

	//If the screen is too small to support horizontal posts, convert all horizontal posts to vertical posts
	if(getTotalWindowWidth() <= horizontalPostWidthLimit){

		//Convert horizontal post to vertical post
		hideElements($('.horizontalPost .fadeRightLine'));

		$('.horizontalPost .flexContainer').each(function(){
			var cnt = $(this).contents();
			$(this).replaceWith(cnt);
		});

		$('.horizontalClampParagraph').height('auto');

		replaceClassForElements($('.horizontalPost'), 'horizontalPost', 'verticalPost');
		replaceClassForElements($('.horizontalPostTextWrapper'), 'horizontalPostTextWrapper', 'verticalPostContentWrapper');
		replaceClassForElements($('.horizontalPostTextFooter'), 'horizontalPostTextFooter', 'verticalPostContentFooter');

		horizontalPostsConvertedToVertical = true;
	}

	else if (horizontalPostsConvertedToVertical){

		//Revert all converted posts back to horizontal posts
		showElements($(".verticalPost[data-original-post-orientation='horizontal'] .fadeRightLine"));
		replaceClassForElements($(".verticalPost[data-original-post-orientation='horizontal'] .verticalPostContentWrapper"), 'verticalPostContentWrapper', 'horizontalPostTextWrapper');
		replaceClassForElements($(".verticalPost[data-original-post-orientation='horizontal'] .verticalPostContentFooter"), 'verticalPostContentFooter', 'horizontalPostTextFooter');
		replaceClassForElements($(".verticalPost[data-original-post-orientation='horizontal']"), 'verticalPost', 'horizontalPost');
		$('.horizontalPost .horizontalClampParagraph p').height('auto');
		$(".horizontalPost").each(function(){

			flexContainer = $("<div class='flexContainer'></div>");
			textContent = $(this).find('.horizontalPostTextWrapper').detach();

			if(isObjectEmpty($(this).find(".hacky-flexbox-fixer"))){
				$(flexContainer).addClass('singleColumn');
			}

			flexContainer.append(textContent);

			$(this).append(flexContainer);

		});

		horizontalPostsConvertedToVertical = false;
	}

}

function showElements(elementArray){

	if(elementArray.length > 0){

		elementArray.each(function(){
			$(this).show();
		});

	}
}

function hideElements(elementArray){

	if(elementArray.length > 0){

		elementArray.each(function(){
			$(this).hide();
		});

	}

}

function replaceClassForElements(elementArray, classToRemove, classToAdd){

	if(elementArray.length > 0){

		elementArray.each(function(){
			$(this).removeClass(classToRemove);
			$(this).addClass(classToAdd);
		});

	}
}

function updateCarouselWrappers(){

	var windowWidth = getTotalWindowWidth();

	//Update wrapper class for carousels who had arrows added as a result of the resize
    $('.carouselContainer .carouselWrapperNoArrows').each(function(){

		//Get the number of columns in the carousel
		var numberOfCarouselColumns = $(this).find(".carouselColumn:not('.slick-cloned')").length;

		if(windowWidth > carouselBreakpointTwoColumn && numberOfCarouselColumns > 3){
			
			$(this).removeClass("carouselWrapperNoArrows");
			$(this).addClass("carouselWrapperArrows");	

		}

		else if(windowWidth > carouselBreakpointOneColumn && numberOfCarouselColumns > 2){

			$(this).removeClass("carouselWrapperNoArrows");
			$(this).addClass("carouselWrapperArrows");	

		}
		
		else if(windowWidth <= carouselBreakpointOneColumn && numberOfCarouselColumns > 1){

			$(this).removeClass("carouselWrapperNoArrows");
			$(this).addClass("carouselWrapperArrows");	

		}

	});
 
    $('.carouselContainer .carouselWrapperArrows').each(function(){

		//Get the number of columns in the carousel
		var numberOfCarouselColumns = $(this).find(".carouselColumn:not('.slick-cloned')").length;

		if(windowWidth >= carouselBreakpointTwoColumn && numberOfCarouselColumns <= 3){
			
			$(this).removeClass("carouselWrapperArrows");
			$(this).addClass("carouselWrapperNoArrows");	

		}

		else if(windowWidth >= carouselBreakpointOneColumn && numberOfCarouselColumns <= 2){

			$(this).removeClass("carouselWrapperArrows");
			$(this).addClass("carouselWrapperNoArrows");	

		}
		
		else if(windowWidth < carouselBreakpointOneColumn && numberOfCarouselColumns <= 1){

			$(this).removeClass("carouselWrapperArrows");
			$(this).addClass("carouselWrapperNoArrows");	

		}

	});

}

function getTotalWindowWidth(){
	return $(window).width() + getScrollBarSize();
}

function getScrollBarSize(){
	
	// Create the measurement node
	var scrollDiv = document.createElement("div");
	scrollDiv.className = "scrollbar-measure";
	document.body.appendChild(scrollDiv);

	// Get the scrollbar width
	var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;

	// Delete the DIV 
	document.body.removeChild(scrollDiv);

	return scrollbarWidth;
}

function convertElementAttributeValueToNumber(element, attributeName){

	if(element && element !== undefined && $(element).css(attributeName) && $(element).css(attributeName) !== undefined){

		var value = $(element).css(attributeName)
		return parseFloat(value);

	}

}

function buildCarousel(){

	var columnWrapper = $(this).closest('.carouselColumnsWrapper');

	if(columnWrapper.length === 0){
		throw ("Could not find column wrapper for carousel");
	}

	else{

		var previousButton = $(columnWrapper).find('.carouselButtonPrevious');
		var nextButton = $(columnWrapper).find('.carouselButtonNext');
		var carouselColumns = $(this).find('.carouselColumn');

		if(previousButton.length === 0){
			throw ("Could not find previous button for carousel.");
		}

		else if(nextButton.length === 0){
			throw ("Could not find previous button for carousel.")	
		}

		else if(carouselColumns === 0){
			throw ("Could not find any caoursel columns.")
		}

		else{

			$(this).slick({
			slidesToShow: Math.min(carouselColumns.length, 3),
			slidesToScroll: 3,
			lazyLoad: 'ondemand',
			prevArrow: previousButton,
			nextArrow: nextButton,
		  	responsive: [
			    {
			      breakpoint: carouselBreakpointTwoColumn,
			      settings: {
			        slidesToShow: Math.min(carouselColumns.length, 2),
			        slidesToScroll: 2
			      }
			    },
			    {
			      breakpoint: carouselBreakpointOneColumn,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }]
	  		});

		}

	}

}

function buildSingleImageCarousel(){

	var carouselWrapper = $(this).closest('.slick-single-image-carousel-wrapper');

	if(carouselWrapper.length === 0){
		throw ("Could not find column wrapper for carousel");
	}

	else{

		var previousButton = $(carouselWrapper).find('.carouselButtonPrevious');
		var nextButton = $(carouselWrapper).find('.carouselButtonNext');
		var carouselColumns = $(this).find('.carouselColumn');

		if(previousButton.length === 0){
			throw ("Could not find previous button for carousel.");
		}

		else if(nextButton.length === 0){
			throw ("Could not find previous button for carousel.")	
		}

		else if(carouselColumns === 0){
			throw ("Could not find any caoursel columns.")
		}

		else{

			$(this).slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				lazyLoad: 'ondemand',
				prevArrow: previousButton,
				nextArrow: nextButton,
				dots: true
			});
		}

	}
}

function buildBannerCarousel(){

	$(this).slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		lazyLoad: 'ondemand',
		infinite: true,
		draggable: false,
		autoplay: false,
  		autoplaySpeed: 2000,
	});
} 

function onBannerChange(event, slick, direction){

}

function configureBounceBoxes(){

	//When the user hovers over a bounce box, intiate the bounce.
	$(".bounceBox").mouseenter(function(){
	  $(this).addClass("bounce");        
	});

	$(".destinationArrowColumn").mouseenter(function(){
		$(this).addClass("highlightArrow");
	})

	$(".destinationArrowColumn").mouseleave(function(){
		$(this).removeClass("highlightArrow");
	})

	//When the bounce is over, remove the bounce class so the bounce box stops bouncing
	$(".bounceBox").bind("webkitAnimationEnd oanimationend animationend MSAnimationEnd", function(){
	  $(this).removeClass("bounce")  
	})

}

function onBannerNext(){

	var fadeSpeed = 500;
	var captionBox = $('#bannerCaptionBox');

	resetBannerAutoPlay();

	$('#slickBannerCarousel').slick("slickNext");

	captionBox.css('visibility','hidden').show().fadeIn('slow', function(){
		configureBannerBox();
		captionBox.css('visibility','visible').hide().fadeIn('slow');
	});



}

function resetBannerAutoPlay(){

	clearTimeout(timeout);

    timeout = setInterval(function() {

    	//Simulate clicking the next button on the banner
        onBannerNext();

    }, 15000);

}

function closeEmailBar(){
	$(".email-footer").slideUp(emailBarSlideSpeed);
}

function isObjectEmpty(object){
	return object === undefined || object === null || object.length === 0;
}

function configureBannerBox(){

	var activeBannerSlide = $('#slickBannerCarousel .slick-active');
	var activeBannerSlideCaption = activeBannerSlide.data('caption');
	var activeBannerLink = activeBannerSlide.data('link');

	if(isObjectEmpty(activeBannerSlideCaption)){
		activeBannerSlideCaption = '';
	}

	if(isObjectEmpty(activeBannerLink)){
		activeBannerLink = ''
	}

	$('#bannerCaption .clampParagraph').text(activeBannerSlideCaption);
	$('#bannerCaptionBoxFooter #bannerPostLink').attr("href", activeBannerLink);

	clampBannerCaption();
}

function fixHackyFlexbox(){

	if(getTotalWindowWidth() <= horizontalPostWidthLimit){

		$(".teamMemberWrapper .verticalPost .hacky-flexbox-fixer").height('auto');
	}

	else{

		$(".teamMemberWrapper .horizontalPost").each(function(){

			var textContainer = $(this).find(".horizontalPostTextWrapper");
			var hackyFlexbox = $(this).find(".hacky-flexbox-fixer");

			if(!isObjectEmpty(textContainer) && !isObjectEmpty(hackyFlexbox)){

				var height = getTotalHeightOfElement(textContainer);
				$(hackyFlexbox).height(height);
			}

		});

	}

}

$( document ).ready(function() {

	configureBounceBoxes();

	//Configure all the carousels
	$('.slick-carousel').each(buildCarousel);
	$('.slick-single-image-carousel').each(buildSingleImageCarousel);
	$('#slickBannerCarousel').each(buildBannerCarousel);

	//Remove the data-lightbox attribute from all the cloned sliders on the carousel, so the lightbox doesn't show a duplicate of all the pictures
	$('.slick-single-image-carousel .carouselColumn.slick-cloned a').each(function(){
		$(this).attr('data-lightbox', "")
	});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true,
      'alwaysShowNavOnTouchDevices': true
    })

    $('.hacky-flexbox-fixer img').each(function(){

    	if(!isIE || $(window).width() <= 767){
    		$(this).addClass("cover");	
    	}
    	
    });

	objectFitImages();

	fixHackyFlexbox();

	//Set the caption for the intial banner slide.
	configureBannerBox();

	window.setTimeout(function(){
		$(".email-footer").slideDown(emailBarSlideSpeed);
	}, 2000 );

    resetBannerAutoPlay();

});
