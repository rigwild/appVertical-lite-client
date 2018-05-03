<?php
require 'functions.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
	$msg = urlencode("The video id you specified is invalid.");
	header("Location: index.php?error=".$msg);
}

/*Remove bad chars before sending*/
$watchId = htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8');

/*Get video details*/
$token = login($username, $password);
$videoData = getVideo($token, $watchId, true);

/*If the server doesn't find the video, redirect to homepage*/
if (isset($videoData['error']) && $videoData['error'] == 'Video not found') {
	$msg = urlencode("The video you are looking for was not found on Vertical.");
	header("Location: index.php?error=".$msg);
}

/*Get all infos*/
$videoInfo = [];
$videoInfo["name"] = (isset($videoData["name"])) ? $videoData["name"] : "";
$videoInfo["description"] = (isset($videoData["description"])) ? $videoData["description"] : "";
$videoInfo["thumbnail"] = (isset($videoData["images"]["large"]["url"])) ? $videoData["images"]["large"]["url"] : "";
$videoInfo["author"] = (isset($videoData["user"]["username"])) ? $videoData["user"]["username"] : "";
$videoInfo["authorAvatar"] = (isset($videoData["user"]["images"]["avatar"]["url"])) ? $videoData["user"]["images"]["avatar"]["url"] : "";
$videoInfo["url_hd"] = (isset($videoData["hdPath"])) ? $videoData["hdPath"] : "";
$videoInfo["url_md"] = (isset($videoData["mdPath"])) ? $videoData["mdPath"] : "";
$videoInfo["url_sd"] = (isset($videoData["sdPath"])) ? $videoData["sdPath"] : "";
$videoInfo["commentsCount"] = (isset($videoData["commentsCount"])) ? $videoData["commentsCount"] : "";
$videoInfo["likesCount"] = (isset($videoData["likes"])) ? $videoData["likes"] : "";

/*Set duration in minutes*/
$videoInfo["duration"] = (isset($videoData["time"])) ? gmdate("i:s", $videoData["time"]) : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Vertical - Lite client - by rigwild</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
	<meta name="description" content="Vertical app lite client. Watch video without downloading the app !" />
	<meta name="keywords" content="app, vertical, appvertical, rigwild, github" />
	<meta name="author" content="Antoine SAUVAGE - rigwild">

	<link rel="icon" href="img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<link rel="stylesheet" type="text/css" href="./font/Poppins/stylesheet.css" />
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
	<div class="container">
		<a href="index.php" class="goHomePage">Back to homepage</a>

		<h1>
			Vertical Lite client
			<span class="rigwild"> by rigwild -
				<a href="https://github.com/rigwild/appVertical-lite-client" target="_blank">
					Github
				</a>
			</span>
		</h1>

		<div class="watchThumbnail">
			<img src="<?=$videoInfo['thumbnail']?>" />
		</div>
		<div class="watchInfos">
			<span class="watchTitle">
				<?=$videoInfo["name"]?>
			</span>
			<span class="watchAuthor">
				by <?=$videoInfo["author"]?> - Duration : <?=$videoInfo["duration"]?> - <?=$videoInfo["likesCount"]?> likes and <?=$videoInfo["commentsCount"]?> comments
			</span>
			<span class="watchDescription">
				Description : 
				<?=$videoInfo["description"]?>
			</span>
			<div class="watchVideo">
				<video controls>
					<source src="<?=$videoInfo['url_hd']?>" type="video/mp4"></source>
				</video>
			</div>
		</div>
	</div>
</body>
</html>