<?php

require '../app/bootstrap.php';

// Create new instances

$app = new \Slim\Slim();

$app->config(array(
	'debug' => true,
	'mode' 	=> 'development',
));

$app->post('/sendsms', function() use ($app){
	
	$response = $app->response();
	$response['Content-Type'] = 'text/xml';

	$url_endpoint = 'http://wms1.wavecell.com/Send.asmx/SendMT';

	$form_data = $app->request->post();

	$accountId 		= 'cloudempl';
	$body 			= $form_data['body'];
	$destination	= $form_data['destination'];
	$encoding		= 'ASCII';
	$password 		= 'Kr1selle';
	$scheddt 		= $form_data['date_time'];
	$source 		= $form_data['source'];
	$subAccountId 	= 'cloudempl_hq';
	$umid 			= '';

	$fields_string 	= '';

	$param 			= array(
			'Body'				=> urlencode($body),
			'Destination' 		=> urlencode($destination),
			'Encoding'			=> urlencode($encoding),
			'Password'			=> urlencode($password),
			'ScheduledDateTime' => urlencode($scheddt),
			'Source'			=> urlencode($source),
			'SubAccountId'		=> urlencode($subAccountId),
			'UMID'				=> urlencode($umid),
			'AccountId' 		=> urlencode($accountId)
	);
	foreach($param as $key=>$value){
		$fields_string .= $key . '=' . $value.'&';
	}

	rtrim($fields_string, '&');

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, $url_endpoint);
	curl_setopt($curl, CURLOPT_POST, count($param));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
});


$app->run();