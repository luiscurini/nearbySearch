<?php

//Using UTF-8
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//Using Curl to get the JSON from the googl URL
function curl($url){
    $curlInit = curl_init();
    curl_setopt($curlInit, CURLOPT_URL, $url);
    curl_setopt($curlInit, CURLOPT_RETURNTRANSFER,1);
    $data = curl_exec($curlInit);
    curl_close($curlInit);
    return $data;
}

//Check if the status of the JSON obtain is 'OK'
function checkStatusValid($status) {
	if ($status == 'OK') {
		return true;
	} 
	return false;
}

//Handle the different error statuses returned from the Google Places API
function printInvalidStatusMessage($status){
	switch ($status) {
		case 'ZERO_RESULTS':
			echo "<h2>No results were found for your query.</h2>";
			break;
		case 'OVER_QUERY_LIMIT':
			echo "<h2>Google Places API has a limit of 1000 request per day, this limit was reached. Please try tomorrow.</h2>";
			break;
		case 'REQUEST_DENIED':
			echo "<h2>The sensor parameter is missing from the URL.</h2>";
			break;
		case 'INVALID_REQUEST':
			echo "<h2>A required parameter is missing, please contact the admin of the site.</h2>";
			break;
		default:
			echo "<h2>An unkwon status was obtained from the Google Places API.</h2>";
			break;
	}
}

if(isset($_GET['query']) && !empty($_GET['query'])) {  
	
	$query = $_GET['query'];

	$settings = parse_ini_file('settings.ini');
	$key = $settings['API_KEY'];

	$url = sprintf($settings['URL_SEARCH_TEXT'],urlencode($query), $key);
	
	try {
		$json = curl($url);
	} catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	
	try {
		$json_data = json_decode($json, true);
	} catch (Exception $e) {
		echo 'Malformed JSON, check the Google Places API';
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}

	$status = $json_data['status'];
	if(checkStatusValid($status)) {

		foreach ($json_data['results'] as $result) {
			
			$name = $result['name'];
			$address = $result['formatted_address'];
			echo $name ." ".$address ."<br/>";
	 	}

	} else {
		printInvalidStatusMessage($status);
	}
} else {
	echo '<h2>Usage:</h2><p>Please enter some of the following parameter.</p>
	<ul><li>query=text+to+search</li></ul>';
}
?>