<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

approve_meeting($_POST['sender_email'], $_POST['user_email'], $_POST['subject']);
?>