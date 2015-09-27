<?php
// Show all errors
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);


// Set default timezone
date_default_timezone_set('America/Chicago');


// Connect to database
$database_username = getenv('MYSQL_USER');
$database_password = getenv('MYSQL_PASS');
$database_host = 'localhost';
$database_name = 'schedule-ninja';
$database_info = 'mysql:host='.$database_host.';dbname='.$database_name;
try
{
    $PDO = new PDO($database_info, $database_username, $database_password);
    $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $e)
{
    echo $e->getMessage();
    exit;
}


// Include the functions
require('/var/www/html/includes/functions.php');
require('/var/www/html/includes/calendar.php');
require('/var/www/html/includes/handle_sendgrid.php');



require_once '/var/www/html/php-libraries/contextio/class.contextio.php';

$contextIO = new ContextIO(getenv('CONTEXTIO_KEY'), getenv('CONTEXTIO_SECRET'));
$accountId = null;
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
    echo 'Scraping ' . $account['id'] . "\t" . join(", ", $account['email_addresses']) . PHP_EOL;
    if (is_null($accountId)) {
        $accountId = $account['id'];
    }
}

$r = $contextIO->listMessages($accountId, array('include_body' => true));
foreach ($r->getData() as $message) {
    $msg_id = $message['message_id'];
    $subject = $message['subject'];
    $date_received = date("Y-m-d H:i:s", $message['date_received']);
    $recipient = $message['addresses']['to'][0]['email'];
    $sender_email = $message['addresses']['from']['email'];
    $sender_name = $message['addresses']['from']['name'];
    $constraints_after = NULL;
    $constraints_before = NULL;
    $requested_date = NULL;
    $hours = 0;

    $main_body = '';
    $bodies = $message['body'];
    foreach ($bodies as $body) {
        if ($body['type'] == 'text/plain') {
            $main_body = $body['content'];
        } elseif ($main_body == '') {
            $main_body = $body['content'];
        }
    }

    print '\t';
    if (is_meeting_request($subject, $main_body)) {
        print 'YES '.$subject.PHP_EOL;
        create_meeting_request('email', $date_received, $recipient, 
            $sender_email, $sender_name, $constraints_after,
            $constraints_before, $requested_date, $hours, $subject, $msg_id, $main_body);
    } else {
        print 'NO  '.$subject.PHP_EOL;
    }
}

?>
