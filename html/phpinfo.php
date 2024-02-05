<?php
echo ("Helllo world!!");
$timestamp = time();
date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d H:i:s', $timestamp);
echo $date;


