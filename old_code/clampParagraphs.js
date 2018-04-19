function clampParagraphs(){

	$(".verticalPost .clampParagraph").each(function(index, item) {
    	$clamp(item, {clamp: determineVerticalPostExcerptHeight(item), useNativeClamp: false});
	});

	$(".horizontalPost .clampParagraph").each(function(index, item) {
    	$clamp(item, {clamp: determineHorizontalPostExcerptHeight(item), useNativeClamp: false});
	});

}

//Determines how tall the post excerpt should be for vertical post boxes
function determineVerticalPostExcerptHeight(paragraphElement){

	var postElement = $(paragraphElement).closest(".verticalPost")

	return determineParagraphHeight(paragraphElement, postElement, $(postElement).find("img"), $(postElement).find("h3")[0], $(postElement).find(".verticalPostTextWrapper")[0], $(postElement).find(".verticalPostContentFooter")[0], null);

}

//Determines how tall the post excerpt should be for horizontal post boxes
function determineHorizontalPostExcerptHeight(paragraphElement){

	var postElement = $(paragraphElement).closest(".horizontalPost")

	return determineParagraphHeight(paragraphElement, postElement, null, $(postElement).find("h3")[0], $(postElement).find(".horizontalPostTextWrapper")[0], $(postElement).find(".horizontalPostTextFooter")[0], $(postElement).find(".fadeRightLine")[0]);

}

//Determines how tall the post excerpt should be in the post boxes.
function determineParagraphHeight(paragraphElement, postElement, postImageElement, postHeaderElement, textWrapperElement, postFooterElement, fadingLineElement){

	var returnHeight = null;
	
	try{

		if(postElement){
			
			var imageHeight = 0;
			var headerHeight = 0;
			var footerHeight = 0;
			var fadingLineHeight = 0;

			//If there is an image, determine how much height it takes up.
			if(!isObjectEmpty(postImageElement)){
				imageHeight = convertElementAttributeValueToInteger(postImageElement, "margin-top") + $(postImageElement).height()
			}

			//If there is a header, determine how much height it takes up.
			if(!isObjectEmpty(postHeaderElement)){
				headerHeight = $(postHeaderElement).height() + convertElementAttributeValueToInteger(postHeaderElement, "margin-top") + convertElementAttributeValueToInteger(postHeaderElement, "margin-bottom");
			}

			//If there is a footer, determine how much height it takes up.
			if(!isObjectEmpty(postFooterElement)){
				footerHeight = $(postFooterElement).height() + convertElementAttributeValueToInteger(postFooterElement, "margin-top") + convertElementAttributeValueToInteger(postFooterElement, "margin-bottom");
			}

			//If there is a fading line, determine how much height it takes up
			if(!isObjectEmpty(fadingLineElement)){
				fadingLineHeight = $(fadingLineElement).height() + convertElementAttributeValueToInteger(fadingLineElement, "margin-top") + convertElementAttributeValueToInteger(fadingLineElement, "margin-bottom");
			}

			//Determine the amount of padding around the post box content
			var wrapperPadding = convertElementAttributeValueToInteger(textWrapperElement, "padding-top") + convertElementAttributeValueToInteger(textWrapperElement, "padding-bottom"); 

			//Determine how much margin is at the bottom of the paragraph itself
			var paragraphMarginBottom = convertElementAttributeValueToInteger(paragraphElement, "margin-bottom");

			//Calculate how much height of the post box is being used by the existing elements
			var accountedForHeight = imageHeight + headerHeight + paragraphMarginBottom + footerHeight + wrapperPadding + fadingLineHeight;

			//Calculate how tall the post description should be
			returnHeight = $(postElement).height() - accountedForHeight;

		}

	}

	catch(error){
		console.log(error);
	}

	//default to three lines
	if (!returnHeight || isNaN(returnHeight)){
		return "3";
	}

	return returnHeight + "px";
}