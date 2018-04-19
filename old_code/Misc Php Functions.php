//Making excerpts be mandatory.
//WARNING! Applies to all post types; if you use this again; should add a filter to only apply to the post type you need
add_filter('wp_insert_post_data', 'mandatory_excerpt');

function mandatory_excerpt($data) {
  $excerpt = $data['post_excerpt'];

  if (empty($excerpt) || isStringNullOrWhiteSpace($excerpt)) {
    if ($data['post_status'] === 'publish') {
      add_filter('redirect_post_location', 'excerpt_error_message_redirect', '99');
    }

    $data['post_status'] = 'draft';
  }

  return $data;
}