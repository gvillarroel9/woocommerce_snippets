<?php

function property_custom_grid($atts = [], $content = null, $tag = ''){
    $atts = array_change_key_case((array)$atts, CASE_LOWER); 
    $wporg_atts = shortcode_atts(
		[
			'category' => '',
		], 
		$atts, 
		$tag);
		$products = wc_get_products(array(
    		'category' => array($atts['category']),
		));

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 10,
			//'product_cat'    => 'hoodies'
		);
		
			$products = new WP_Query( $args );
			//print("<pre>".print_r($products,true)."</pre>");
			foreach ($products->posts as $product){			
				//print_r($product);
				//print("<pre>".print_r(wc_get_product( $product->ID),true)."</pre>");
				print("<pre>"
						//.wc_get_product($product->ID)->get_name().
						.wp_get_attachment_image_url(wc_get_product($product->ID)->get_image_id(), 'full' ).
						//.get_post_meta( $product->ID, '_product_attributes')[0]['dormitorio']['value'].
						//.get_post_meta( $product->ID, '_product_attributes')[0]['bano']['value'].
						//.print_r(get_post_meta($product->ID, '_product_attributes'),true).
					  "</pre>");
			}
		return $atts['category'];
}


    add_shortcode( 'property_grid', 'property_custom_grid' );

?>
