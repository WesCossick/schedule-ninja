<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

$suggestions = suggested_times([$_POST['user_email']]);

reply_request($_POST['id']);

approve_meeting($_POST['sender_email'], $_POST['user_email'], $_POST['subject'], $suggestions);
?>