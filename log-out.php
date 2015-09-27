<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

session_destroy();
session_regenerate_id(true);

header('Location: /');
?>