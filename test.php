<?php require('config/main.php'); ?>

<?php

function random_string($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while($length--)
    {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    
    return $str;
}

for ($i = 0; $i < 10; $i++) {
    $type = $i % 2 == 0 ? 'direct' : 'email';
    $int = mt_rand(1440646225,1443334681);
    $date_received = date("Y-m-d H:i:s", $int);
    $recipient = $i % 3 == 0 ? 'grilled.moose@gmail.com' : 'htx@samueltaylor.org';
    $sender_name = random_string(9, 'abcdefghijklmnopqrstuvwxyz');
    $sender_email = "$sender_name@samueltaylor.org";
    $hours = rand(1, 6);

    $constraints_after = $i % 4 == 0 ? NULL : date("Y-m-d H:i:s", $int);
    $constraints_before = $i % 3 == 0 ? NULL : date("Y-m-d H:i:s", $int + 60 *
        60 * 24 * 7);
    $requested_date = NULL;

    create_meeting_request($type, $date_received, $recipient, $sender_email,
        $sender_name, $constraints_after, $constraints_before, $requested_date, $hours);
}

echo 'yey';
?>
