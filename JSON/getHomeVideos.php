<?php

require '../functions.php';
header('Content-Type: application/json');

$username = "testazerty";
$password = "testazerty";
$token = login($username, $password);

$linkList = getHomeVideoData($token);
$linkList = json_encode($linkList, JSON_PRETTY_PRINT);

echo $linkList;

file_put_contents("videos.json", json_encode($linkList, JSON_PRETTY_PRINT));
?>