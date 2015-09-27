<?php
require '/var/www/html/php-libraries/sendgrid-php/sendgrid-php.php';

$SENDGRID_USER = getenv('SENDGRID_USER');
$SENDGRID_PASS = getenv('SENDGRID_PASS');

function reject_meeting($to_address, $from_address, $original_subject)
{
    $name = get_name_of_user($from_address);
    $subject = 'RE:'.$original_subject;
    $text = 'Hello,'.PHP_EOL.PHP_EOL.'I am '.$name.'\'s personal Schedule Ninja! '
            .$name.' got your meeting request, but unfortunately cannot meet with you. '.
			'We apologize for any inconvenience!'.PHP_EOL.PHP_EOL.'Thanks!'.PHP_EOL.
            PHP_EOL.'Schedule Ninja'.PHP_EOL;
    $html = '<strong>'.$text.'</strong>';
    
    send_email($to_address, $subject, $text, $html);
}

function send_meeting($to_address, $from_address)
{
    $name = get_name_of_user($from_address);
    $subject = $name.' would like to schedule a meeting!';
    $text = 'Hello,'.PHP_EOL.PHP_EOL.'I am '.$name.'\'s personal Schedule Ninja! '
            .$name.' has requested that I set up a meeting with you. '.
            'Are you free from blank to blank?'.PHP_EOL.PHP_EOL.'Thanks!'.PHP_EOL.
            PHP_EOL.'Schedule Ninja'.PHP_EOL;
    $html = '<strong>'.$text.'</strong>';
    
    send_email($to_address, $subject, $text, $html);
}

function approve_meeting($to_address, $from_address, $original_subject)
{
    $name = get_name_of_user($from_address);
    $subject = 'RE:'.$original_subject;
    $text = 'Hello,'.PHP_EOL.PHP_EOL.'I am '.$name.'\'s personal Schedule Ninja! '
            .$name.' got your meeting request, and would love to schedule a time'.
            ' to meet. Are you free from blank to blank?'.PHP_EOL.PHP_EOL.'Thanks!'.PHP_EOL.
            PHP_EOL.'Schedule Ninja'.PHP_EOL;
    $html = '<strong>'.$text.'</strong>';
    
    send_email($to_address, $subject, $text, $html);
}

function send_email($to_address, $subject, $text, $hmtl)
{
    global $SENDGRID_USER, $SENDGRID_PASS;
    
    $sendgrid = new SendGrid($SENDGRID_USER, $SENDGRID_PASS);
    $email    = new SendGrid\Email();
    $email->addTo($to_address)->
        setFrom('contact@getschedule.ninja')->
        setSubject($subject)->
        setText($text)->
        setHtml($html);
    
    $sendgrid->send($email);
}

function get_name_of_user($from_address)
{
    global $PDO;
    
    $query = "SELECT * FROM users WHERE email = :from_address";
    $statement = $PDO->prepare($query);
    $params = array(
        'from_address' => $from_address,
    );
    $statement->execute($params);
    $row = $statement->fetch();
    
    return $row['first_name'];
}

?>
