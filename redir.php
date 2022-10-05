<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$token = $_GET['token'];

try{
    $conn = new PDO('mysql:host=localhost;dbname=short_link_database', 'root', '');
}
catch (PDOException $e){
    echo "Error! " . $e->getMessage();
    die();
}

header("Location: " . Token::GetOriginalLink($conn, $token));