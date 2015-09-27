<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

$suggestions = suggested_times([$_POST['user_email']]);

confirm_request($_POST['id']);

echo json_encode($suggestions, true);
?>