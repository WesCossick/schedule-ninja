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
    
    
    // Initiliaze
    $events = [];
    
    
    // Get refresh token
    $query = "SELECT refresh_token FROM users WHERE email = :email";
    $statement = $PDO->prepare($query);
    $params = array(
        'email' => $email,
    );
    $statement->execute($params);
    $refresh_token = $statement->fetchColumn();
    
    
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
    
    
    // API call
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/calendar/v3/users/me/calendarList');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$access_token));

    if(($response = curl_exec($ch)) === false)
    {
        echo 'cURL Error: '.curl_error($ch).PHP_EOL.PHP_EOL;
        continue;
    }

    curl_close($ch);


    // Get JSON and token
    $json = json_decode($response, true);
    
    
    // Loop over calendars
    foreach($json['items'] as $item)
    {
        // API call
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/calendar/v3/calendars/'.$item['id'].'/events');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$access_token));

        if(($response = curl_exec($ch)) === false)
        {
            echo 'cURL Error: '.curl_error($ch).PHP_EOL.PHP_EOL;
            continue;
        }

        curl_close($ch);


        // Get JSON and token
        $json2 = json_decode($response, true);
        
        
        // Loop over events
        foreach($json2['items'] as $item2)
        {
            $events[] = array(
                'start' => strtotime($item2['dateTime']),
                'end' => strtotime($item2['dateTime']),
            );
        }
    }
    
    
    // Return
    print_r($events);
    return $events;
}
?>