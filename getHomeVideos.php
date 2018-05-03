<?php

require 'functions.php';
header('Content-Type: application/json');

$username = "testazerty";
$password = "testazerty";
$token = login($username, $password);
// var_dump(getHome($token));

// var_dump(getVideo($token, "5a4683b167311e780826314e", true));
$linkList = getHomeVideoData($token);

$linkList = json_encode($linkList, JSON_PRETTY_PRINT);

echo $linkList;
file_put_contents("videos.json", json_encode($linkList, JSON_PRETTY_PRINT));
?>