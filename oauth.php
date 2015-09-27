<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');


// Setup params
$curl_params = array(
    'code' => $_GET['code'],
    'redirect_uri' => 'https://getschedule.ninja/oauth',
    'client_id' => '1063760492812-09qojd13nsodupbo0a9ki0oeg60fo4os.apps.googleusercontent.com',
    'client_secret' => 'bLdqH3OhmjVYsY5m4VFSa3Fs',
    'scope' => '',
    'grant_type' => 'authorization_code',
);


// API call
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v3/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_params);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

if(($response = curl_exec($ch)) === false)
{
    echo 'cURL Error: '.curl_error($ch).PHP_EOL.PHP_EOL;
    continue;
}

curl_close($ch);


// Return JSON response
$json = json_decode($response, true);

print_r($response);
print_r($json);


// Redirect
//header('Location: /');
?>