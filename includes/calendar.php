<?php
function free_time()
{
    // Globals
    global $PDO;
}

function get_all_events($email)
{
    // Globals
    global $PDO;
    
    
    // Get refresh token
    echo 'email: '.$email;
    $query = "SELECT refresh_token FROM users WHERE email = :email";
    $statement = $PDO->prepare($query);
    $params = array(
        'email' => $email,
    );
    $statement->execute($params);
    $refresh_token = $statement->fetch();
    print_r($refresh_token);
    
    
    // Setup params
    $curl_params = array(
        'grant_type' => 'refresh_token',
        'client_secret' => 'bLdqH3OhmjVYsY5m4VFSa3Fs',
        'refresh_token' => $refresh_token,
        'client_id' => '1063760492812-09qojd13nsodupbo0a9ki0oeg60fo4os.apps.googleusercontent.com',
    );


    // API call
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v3/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curl_params));
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


    // Get JSON and token
    $json = json_decode($response, true);
    $access_token = $json['access_token'];
    print_r($json);
    
    
    // Setup params
    $curl_params = array(
        'grant_type' => 'refresh_token',
        'client_secret' => 'bLdqH3OhmjVYsY5m4VFSa3Fs',
        'refresh_token' => $refresh_token,
        'client_id' => '1063760492812-09qojd13nsodupbo0a9ki0oeg60fo4os.apps.googleusercontent.com',
    );


    // API call
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/calendar/v3/users/me/calendarList');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curl_params));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: '.$access_token));
    echo $access_token;

    if(($response = curl_exec($ch)) === false)
    {
        echo 'cURL Error: '.curl_error($ch).PHP_EOL.PHP_EOL;
        continue;
    }

    curl_close($ch);


    // Get JSON and token
    $json = json_decode($response, true);
    print_r($json);
}
?>