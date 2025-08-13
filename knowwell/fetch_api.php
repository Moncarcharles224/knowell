<?php
// Set headers to allow cros-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// link of a third-party aPI that returns a random fact
$api_url = 'https://uselessfacts.jsph.pl/random.json?language=en';

// Use file_get_contents to feth data from the API
$response = @file_get_contents($api_url);

// Check if the request was sucessful
if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not fetch data from the API.']);
    exit;
}

// Echo the API response directly to the front-end
echo $response;
?>