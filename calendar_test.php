<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

$events = get_all_events('grilled.moose@gmail.com');

$free_time = free_time('grilled.moose@gmail.com');
print 'Free time:<br>';
var_dump($free_time);
print '<br><br>Events:<br>';
var_dump($events);

$out = suggested_times('grilled.moose@gmail.com');
print_r($out);

?>
