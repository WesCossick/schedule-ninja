<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

reject_meeting($_POST['sender_email'], $_POST['user_email'], $_POST['subject']);
?>