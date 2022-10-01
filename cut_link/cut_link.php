<?php
require_once '../hashids/HashGenerator.php';
require_once '../hashids/Hashids.php';

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $hashids = new \Hashids\Hashids('', 6);

    $link = $_POST["link"];

    $id = $hashids->encode(rand());

    echo '/' . $id;
}