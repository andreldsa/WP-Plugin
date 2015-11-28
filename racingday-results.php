<?php
/**
* Plugin Name: Racing Day Nordeste Resultados
* Plugin URI: http://racingdaynordeste.com.br
* Version: 1.0
* Author: André L. Abrantes
* Author URI: http://andreabrantes.com
* License: GPL12
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'functions.php';

// Return all post IDs
function dt_get_all_post_ids() {
    if ( false === ( $all_post_ids = get_transient( 'dt_all_post_ids' ) ) ) {
        $all_post_ids = get_posts( array(
            'numberposts' => -1,
            'post_type'   => 'post',
            'fields'      => 'ids',
        ) );
    }

    return $all_post_ids;
}

add_action( 'rest_api_init', function () {
	// Add deep-thoughts/v1/get-all-post-ids route
	register_rest_route( 'resultados/v1', '/getAll/', array(
	    'methods' => 'GET',
	    'callback' => 'dt_get_all_post_ids',
	) );
} );

?>