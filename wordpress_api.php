<?php

function events_endpoint() {
    register_rest_route( 'eventos','roulette', array(
        'methods'  => 'POST',
        'callback' => 'get_events',
    ) );
}
add_action( 'rest_api_init', 'events_endpoint' );
 
function get_events( $request ) {
	$roulette = get_gift();
	if(db_roulette($_POST['email'], $roulette['gift'])){		
		send_email_roulette($_POST['email'], $roulette['gift']);
		return $roulette;
	} else{
		return array(
			'gift' => 'Este correo ya recibio un premio',
			'random' => 0
		);
	} 	
    
}

function send_email_roulette( $email, $gift) {
	
	global $phpmailer;
	
	// (Re)create it, if it's gone missing
	if ( ! ( $phpmailer instanceof PHPMailer ) ) {
		require_once ABSPATH . WPINC . '/class-phpmailer.php';
		require_once ABSPATH . WPINC . '/class-smtp.php';
	}
	$phpmailer = new PHPMailer;
	
	// SMTP configuration
	$phpmailer->isSMTP();                    
	$phpmailer->Host = 'mail.justseo.online';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Username = 'contacto@justseo.online';
	$phpmailer->Password = 'q6X*,mVHUWNM';
	$phpmailer->SMTPSecure = 'tls';
	$phpmailer->Port = 587;

	$phpmailer->setFrom('contacto@justseo.online', 'Contacto');

	// Add a recipient
	$phpmailer->addAddress($email);

	// Set email format to HTML
	$phpmailer->isHTML(true);

	// Email subject
	$phpmailer->Subject = 'Premio Il Mio Spazio';

	// Email body content
	$mailContent = "<h1> ¡Has ganado! ".$gift."</h1>";
	$phpmailer->Body    = $mailContent;

	if(!$phpmailer->send()){
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
	}else{
		//echo 'Message has been sent';
	}
}


function get_gift(){
	
	$randomNumber = rand(1, 359);
	$count = 0;
	$gift = "";
	// 0,90 180,270
	while (($randomNumber >= 0 && $randomNumber < 90) || ($randomNumber >= 180 && $randomNumber < 270) && count < 5)
	{
		$randomNumber = rand(1, 359);
		$count++;
	}

	if ($randomNumber >= 0 && $randomNumber < 45)
	{
		
		$gift = "30% de descuento en manicure tradicional.";
	}
	else if ($randomNumber >= 45 && $randomNumber < 90)
	{
		
		$premio = "30% de descuento en perfilados de cejas.";
	}
	else if ($randomNumber >= 90 && $randomNumber < 180)
	{
		
		$gift = "10% de descuento en todos los servicios de salón y barberia";
	}
	else if ($randomNumber >= 180 && $randomNumber < 225)
	{
		
		$gift = "GIFT CARD de $50.000 canjeables en cualquier servicio menos ventas de productos.";
	}
	else if ( $randomNumber >= 225 && $randomNumber < 270)
	{
		
		$gift = "20% de descuento en tratamientos capilares los dias jueves por otoño e invierno";
	}
	else if ( $randomNumber >= 270 && $randomNumber < 360)
	{
		
		$gift = "15% de descuento en tratamiento capilar chemistry";
	}
	
	return array
	(
		'gift' => $gift,
		'random' => $randomNumber
	);
}




function db_roulette($email,$gift){	
	global $wpdb;
	return $wpdb->insert('roulette_list', array(
		'email' => $email,
		'reward' => $gift
	));	
}


function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}