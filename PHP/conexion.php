<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'db5016642491.hosting-data.io';
$db = 'dbs13488317';
$user = 'dbu1342146';
$password = 'S3eKerU7m*';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>