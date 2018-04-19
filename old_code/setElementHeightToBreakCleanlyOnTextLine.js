function setElementHeightToBreakCleanlyOnTextLine(contentElement, availableHeight){

	var contentHeight = 0;

	if(!isObjectEmpty(contentElement)){

		//Reset the height of the content to undo any previous height calculations
		contentElement.height("auto");

		contentHeight = getTotalHeightOfElement(contentElement);
	}

	//If the content takes up more space than is available, calculate how many lines can be show, and then
	//give the content an explicit height
	if(contentHeight > availableHeight){
		
		//Get the line height of the content
		contentLineHeight = convertElementAttributeValueToNumber(contentElement, "line-height");

		//Calculate how many lines can be show in the available space
		maxLines = availableHeight / contentLineHeight;

		//Floor the number of lines so that the bottom one isn't partially showing
		maxLines = Math.floor(maxLines);

		//Calculate the height with the new number of lines
		contentHeight = maxLines * contentLineHeight;

		//Set the new height
		contentElement.height(contentHeight);

	}

}