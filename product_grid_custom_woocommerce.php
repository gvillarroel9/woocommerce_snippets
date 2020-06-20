//[property_grid category="santiago" qty="4"]

	function property_custom_grid($atts = [], $content = null, $tag = ''){
    	$atts = array_change_key_case((array)$atts, CASE_LOWER); 
    	$wporg_atts = shortcode_atts(
			[
				'category' => '',
				'qty' => '',
			], 
			$atts, 
			$tag);
		
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 10
		);
		
		if(!empty($wporg_atts['category'])){
			$args['product_cat'] = $wporg_atts['category'];
		}
		
		$products = new WP_Query( $args );
		
		$quantity = count($products->posts);
		
		if($quantity<0){
			return 'No hay productos para mostrar';
		}
		
		if(!empty($wporg_atts['qty'])&&$wporg_atts['qty']<$quantity){
			$quantity =$wporg_atts['qty'];
		}
		
		$grid_cards= '<div class="grid-card-products">';
		for($i=0; $i<$quantity; $i++){
			$grid_cards .='<div class="card"><div class="card-header">';
			$current_product = wc_get_product($products->posts[$i]->ID);
			$grid_cards .= '<div>'.$current_product->get_name().'</div>';
			$grid_cards .= '<div class="card-header-icon"><i class="fa fa-map-marker"></i></div></div>';
			$grid_cards .= '<div class="card-img" style="background-image: url('
				.wp_get_attachment_image_url($current_product->get_image_id(),'full').
				');">';
			$grid_cards .= '<div class="card-img-icon"><img src="https://www.tearriendo.cl/wp-content/uploads/2020/06/icono-cama-04.png">';
			$grid_cards .= '<h1>'.get_post_meta( $products->posts[$i]->ID, '_product_attributes')[0]['dormitorio']['value'].'H</h1></div>';
			$grid_cards .= '<div class="card-img-icon"><img src="https://www.tearriendo.cl/wp-content/uploads/2020/06/icono-ducha-05.png">';
			$grid_cards .= '<h1>'.get_post_meta( $products->posts[$i]->ID, '_product_attributes')[0]['bano']['value'].'B</h1></div></div>';
			$grid_cards .= '<a class="card-footer" href='.get_permalink( $products->posts[$i]->ID ).'>';
			$grid_cards .='<div>Detalles de la propiedad</div><div class="card-footer-icon"><i class="fa fa-search"></i></div></a></div>';
		}
		$grid_cards .= '</div>';
		$grid_cards .= ' <style>

        .grid-card-products{
            display: grid;
            grid-template-columns: repeat( auto-fit, minmax(250px, 1fr) );
            grid-gap: 1%;
        }

        .card-header {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #464445;
            color: white;
            padding: 10px 5px;
            font-size: 15px;
            font-weight: 600;
        }

        .card-img-icon {
            display: flex;
            align-items: center;
            margin: 0 10px;
            color: white;
        }

        .card-img i{
            font-size: 40px;
            color: white;
            margin-right: 5px;            
        }

        .card-header-icon {
            font-size: 50px;
            margin-bottom: -25px;
        }

        .card-img {
            height: 250px;
            background-size: cover;
            display: flex;
            align-items: flex-end;
        }

        .card-footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            border: none;
            padding: 5px 5px;
            color: white;
            font-size: 15px;
            font-weight: 900;
            background-color: #95171C;
        }
		
		.card-footer:hover{
			color:white;
			background-color:#95171cbd;
		}
		.card-footer:visited{
			color:white;
		}

        .card-footer-icon {
            font-size: 40px;
        }
		
		.card-img-icon img{
            width: 42px;
        }

    </style>';
		return $grid_cards;
    }
	


    add_shortcode( 'property_grid', 'property_custom_grid' );


