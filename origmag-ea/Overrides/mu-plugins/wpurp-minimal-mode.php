<?php
/* plugin to turn off ultimate recipe plugin on from loading on some pages, for performance sake */

function wpurp_minimal_mode( $minimal_mode, $url ) {
    if( $url == '/' ) return true; // Homepage

    preg_match( "/^\/user/i", $url, $matches );
    if( count( $matches ) > 0 ) return true; // Any URL starting with /user

    return false;
}
add_filter( 'wpurp_minimal_mode', 'wpurp_minimal_mode', 10, 2 );
