<!DOCTYPE html>
<html>
<body>

<?php
	include('textlocal.class.php');
	// Textlocal account details
	$username = 'simplysourabh_123@yahoo.com';
	$hash = '463852291c9f9f0b46ded83e71bcc6887ae13955';
	
	// Message details
	$numbers = 917389472422;
	$sender = urlencode('Sourabh');
	$message = rawurlencode('I am testing textlocal SMS API');
 
    $numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('http://api.txtlocal.com/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	echo $response;
	
?>

</body>
</html>
