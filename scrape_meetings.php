<?php
require('config/main.php');
require_once 'php-libraries/contextio/class.contextio.php';

$contextIO = new ContextIO(getenv('CONTEXTIO_KEY'), getenv('CONTEXTIO_SECRET'));
$accountId = null;
$r = $contextIO->listAccounts();
foreach ($r->getData() as $account) {
	echo $account['id'] . "\t" . join(", ", $account['email_addresses']) . "\n";
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
    $sender_email = $message['addresses']['from'][0]['email'];
    $sender_name = $message['addresses']['from'][0]['name'];
    $constraints_after = NULL;
    $constraints_before = NULL;
    $requested_date = NULL;
    $hours = NULL;

    $main_body = '';
    $bodies = $message['body'];
    foreach ($bodies as $body) {
        if ($body['type'] == 'text/plain') {
            $main_body = $body['content'];
        } elseif ($main_body == '') {
            $main_body = $body['content'];
        }
    }

    if (is_meeting_request($subject, $main_body)) {
        print create_meeting_request('email', $date_received, $recipient, 
            $sender_email, $sender_name, $constraints_after, 
            $constraints_before, $requested_date, $hours);
    } else {
        print 'not a meeting request';
    }
}

print 'Done printing'

?>
