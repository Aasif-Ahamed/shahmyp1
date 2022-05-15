<?php
$username = 'root';
$password = '';
$hostname = 'localhost';
$db = 'pmedic';

$conn = mysqli_connect($hostname, $username, $password, $db);
if (!$conn) {
    echo 'Server Error - 404';
}
