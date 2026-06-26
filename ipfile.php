<?php

$ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

echo "IP Address: " . $ip . "<br>";
echo "Browser Info: " . $userAgent . "<br>";