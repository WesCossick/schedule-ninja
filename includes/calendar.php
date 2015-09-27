<?php
function suggested_times($email)
{
    global $PDO;
    
    $hours = 1;
    
    $free = free_time($email);
    
    for($i = 0; $i < 7; $i++)
    {
        for($j = 8; $j < 18; $j++)
        {
            $is_free = false;
            $unix = strtotime('+'.$i.' days '.$j.' hours', strtotime(date('Y-m-d', strtotime('+1 day'))));
            foreach($free as $free_time)
            {
                if($unix >= $free_time['start'] && $unix+$hours*3600 <= $free_time['end'])
                {
                    $is_free = true;
                    $j += 4;
                }
            }
            if($is_free)
            {
                $suggestions[] = array(
                    'start' => $unix,
                    'friendly_start' => date('Y-m-d H:i:s', $unix),
                    'end' => $unix+$hours*3600,
                );
            }
            
        }
    }
    
    return $suggestions;
}

function free_time($email)
{
    // Globals
    global $PDO;
    
    $events = get_all_events($email);

    $start = time();
    $end = strtotime('+7 days');

    $free = array();

    $prev = $start;
    foreach ($events as $event) {
        if ($prev < $event['start']) {
            $free[] = array('start' => $prev, 'end' => $event['start']);
        }
        $prev = $event['end'];
    }
    if ($prev < $end) {
        $free[] = array('start' => $prev, 'end' => $end);
    }
    return $free;
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
        if(is_array($json2['items']))
            foreach($json2['items'] as $item2)
            {
                $events[] = array(
                    'start' => strtotime($item2['start']['dateTime']),
                    'end' => strtotime($item2['end']['dateTime']),
                );
            }
    }
    
    
    // Return
    return $events;
}
?>
