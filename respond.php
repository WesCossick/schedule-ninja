<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

confirm_stuff($_GET['sender'], $_GET['recipient']);

header("Location: /?success=You're scheduled for ".date('m/d/Y', $_GET['time']).' at '.date('H:i', $_GET['time']));
?>