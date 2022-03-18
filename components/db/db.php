<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'hypnos';

try {
    $bdd = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}