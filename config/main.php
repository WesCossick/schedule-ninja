<?php
// Connect to database
$database_username = getenv('MYSQL_USER');
$database_password = getenv('MYSQL_PASS');
$database_host = 'localhost';
$database_name = '';
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


// Set default timezone
date_default_timezone_set('America/Chicago');


// Start session
session_start();
?>