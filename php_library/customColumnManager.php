<?php

/**Includes everything necessary to create custom columns in the admin area grids **/

/** Hooks for setting of 'Order' column of the Edit Team Member gride **/
add_filter('manage_team_member_posts_columns', 'addOrderColumnToTeamMemberGrid', 10);
add_action('manage_team_member_posts_custom_column', 'addOrderValueToTeamMemberGrid', 10, 2);
add_filter( 'posts_clauses', 'manage_wp_posts_be_qe_posts_clauses', 1, 2 );
add_filter( 'manage_edit-team_member_sortable_columns', 'addOrderColumnToSortByArray' );

/**
* Adds a column for the 'Order' field of Team Members in the edit Team Members grid.
**/
function addOrderColumnToTeamMemberGrid($defaults) {

	$defaults = array_slice($defaults, 0, 2, true) + array("order" => "Order") + array_slice($defaults, 2, count($defaults)-2, true);

    return $defaults;
}


 /**
 * Populates the 'Order' column of the edit Team Member grid.
 **/
function addOrderValueToTeamMemberGrid($column_name, $post_ID) {
    if ($column_name == 'order') {
        echo get_field( 'order', $post_ID );
    }
}


/**
* Makes the 'Order' column of the edit Team Member grid sortable.
**/
function addOrderColumnToSortByArray( $columns ) {

    $columns['order'] = 'order';
 
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}


/**
*	Tells wordpress how to order the 'Order' column of the edit Team Member grid.
**/
function manage_wp_posts_be_qe_posts_clauses( $pieces, $query ) {
   global $wpdb;

   /**
    * We only want our code to run in the main WP query
    * AND if an orderby query variable is designated.
    */
   if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

      // Get the order query variable - ASC or DESC
      $order = strtoupper( $query->get( 'order' ) );

      // Make sure the order setting qualifies. If not, set default as ASC
      if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) )
         $order = 'ASC';

      switch( $orderby ) {
	
         // If we're ordering by release_date
         case 'order':
			
            /**
             * We have to join the postmeta table to
             * include our release date in the query.
             */
            $pieces[ 'join' ] .= " LEFT JOIN $wpdb->postmeta wp_rd ON wp_rd.post_id = {$wpdb->posts}.ID AND wp_rd.meta_key = 'order'";
				
            // Then tell the query to order by our custom field.
            // The STR_TO_DATE function converts the custom field
            // to a DATE type from a string type for
            // comparison purposes. '%m/%d/%Y' tells the query
            // the string is in a month/day/year format.
            $pieces[ 'orderby' ] = "CASE wp_rd.meta_value WHEN '' THEN 9999 ELSE wp_rd.meta_value END $order, " . $pieces[ 'orderby' ];
				
         break;
		
      }
	
   }

   return $pieces;

}

?>