<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

$suggestions = suggested_times([$_POST['user_email']]);

echo json_encode($suggestions, true);
?>