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
    var_dump($message);
}

?>
