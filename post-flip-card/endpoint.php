<?php

function recetas_endpoint() {
    register_rest_route( 'recetas','pagina/(?P<page>\d+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'get_recetas',
    ) );
}
add_action( 'rest_api_init', 'recetas_endpoint' );
 
function get_recetas( $request ) {
		
    $args = array(
		"posts_per_page"   => 4,
		"paged"            => $request['page'],
		"category_name" => "recetas"
	);
	$posts = new WP_Query( $args );
	
	
	$response = array (
		'posts' => array_map("find_image", $posts->posts),
		'pages' => $posts->max_num_pages,
		'current_page' => $request['page']
	);
	return $response;
}


function find_image( $post){
	$post->img_url = get_the_post_thumbnail_url( $post ,'post-thumbnail');
	return $post;
}