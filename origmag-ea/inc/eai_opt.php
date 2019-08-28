<?php
/*
* optimizing WP_Query
*   zig 27Aug19
*/
function eai_pre_get_posts( $query ) {
  if ( is_admin() || ! $query->is_main_query() ){
	return;
  }

  $query->set( 'no_found_rows', true );
  //$query->set( 'update_post_meta_cache', false );
  //$query->set( 'update_post_term_cache', false );
}
add_action( 'pre_get_posts', 'eai_pre_get_posts', 1 );
