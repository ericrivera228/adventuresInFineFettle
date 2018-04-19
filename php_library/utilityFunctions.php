<?php

/** Includes all helper functions used throughout the site **/

function isStringNullOrWhiteSpace($string){

	if($string != null && trim($string) != ''){
		return false;
	}

	return true;
}

//Wrapper function for get_permalink that ensures the given page title is valid (and throws and error if it is not) and
//escapes the URL.
function getPagePermalinkByPageName($pageName){

	$page = get_page_by_title( $pageName );

	if($page == null){
		throw new Exception("Could not find page '".$pageName."'.");
	}

	$url = get_permalink( $page );

	if($url == null){
		throw new Exception("Could not fun URL for page '".$pageName."'.");
	}

	return esc_url( $url );
}

function renderImgElement($imgElement, $imgClasses = "", $slickLazyLoad = false){

	$imageUrl = $imgElement['url'];
	$imageAlt = $imgElement['alt'];

	if(isStringNullOrWhiteSpace($imageUrl)  != true){
		
		if($slickLazyLoad){
			$imageUrl = "data-lazy='".$imageUrl."'";
		}
		else{
			$imageUrl = "src='".$imageUrl."'";	
		}

	}
	else{
		$imageUrl = "";	
	}

	//Null checks on all the fields
	$imageAlt = isStringNullOrWhiteSpace($imageAlt) != true ? "alt='".$imageAlt."'" : "";
	$imgClasses = isStringNullOrWhiteSpace($imgClasses) != true ? "class='".$imgClasses."'" : "";

	echo "<img ".$imageUrl." ".$imgClasses." ".$imageAlt.">";

}

function getAllRegions(){

	//Grab all the regions that have at least one destination attached to them.
	$categoryGetArguments = array(
	    'parent '       => 0,
	    'hide_empty'    => true,           
	);

	return get_terms( 'region' , $categoryGetArguments);

}

function getDestinationsByRegion($region){

	return get_posts(
	    array(
	        'posts_per_page' => -1,
	        'post_type' => 'destination',
	        'tax_query' => array(
	            array(
	                'taxonomy' => 'region',
	                'field' => 'term_id',
	                'terms' => $region->term_id,
	            )
	        )
	    )
	);

}

function getLatestPostsWithBannerPicture(){

	//Create query arguments that get all the posts that have a banner picture set.
	$args = array(
		'numberposts' => '3', 
		'post_type' => 'post',
		'orderby' => 'post_date', 
		'order' => 'DESC',
       	'post_status' => 'publish',
        'meta_query' => array(
        	array(
				'key' => 'banner_picture',
				'compare' => '!=',
				'value'   => ''
        	)
       )
	);

	return get_posts($args);

}

function getAllTeamMembers(){

	return get_posts(
	    array(
	        'posts_per_page' => -1,
	        'post_type' => 'team_member'
	    )
	);

}

?>