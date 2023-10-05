<?php
$host = 'localhost';
$db   = 'funds_management';
$user = 'root'; // Update as needed
$pass = '';     // Update as needed

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
