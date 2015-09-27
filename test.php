<?php require('config/main.php'); ?>

<?php
for ($i = 0; $i < 10; $i++) {
    $type = $i % 2 == 0 ? 'direct' : 'email';

    $int = mt_rand(1440646225,1443334681);
    $date_received = date("Y-m-d H:i:s", $int);
    $recipient = $i % 2 == 0 ? 'grilled.moose@gmail.com' : 'htx@samueltaylor.org';
    $sender_name = '';
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    for ($i = 0; $i < 9; $i++) {
        $sender_name .= $characters[rand(0, $charactersLength - 1)];
    }
                            }
    $sender_email = "$sender_name@samueltaylor.org";

    $constraints_after = $i % 4 == 0 ? NULL : date("Y-m-d H:i:s", $int);
    $constraints_before = $i % 3 == 0 ? NULL : date("Y-m-d H:i:s", $int + 60 * 
        60 * 24 * 7);
    $requested_date = NULL;

    create_meeting_request($type, $date_received, $recipient, $sender_email, 
        $sender_name, $constraints_after, $constraints_before, $requested_date);
}

echo 'yey';
?>
