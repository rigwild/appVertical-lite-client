<?php
require '../functions.php';

ini_set('xdebug.var_display_max_depth', 20);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);

/*
$username = "testazerty";
$password = "testazerty";
$token = login($username, $password);
$linkList = getHome($token);
*/

$cacheFile = "cache.json";
//saveJsonToFile($linkList, $cacheFile, true);
$linkList = getPhpFromFile($cacheFile);

//var_dump($linkList);
?>


<!DOCTYPE html>
<html>
<head>
	<title>Vertical - Lite client - by rigwild</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<link rel="stylesheet" type="text/css" href="./font/Poppins/stylesheet.css" />
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>
	<div class="container">

		<?php
		foreach ($linkList["results"] as $keySer => $series) {
			$seriesId = $series["_id"];
			$seriesName = $series["name"];
			$seriesDescription = $series["description"];
			$seriesAuthorId = $series["user"]["_id"];

			?>
			<div class='series'>
				<span class='seriesTitle'>
					<?=$seriesName?>
				</span>
				<div class='seriesVideos'>
					<?php
					foreach ($series["videos"] as $keyVid => $video) {
						$videoId = $video["_id"];
						$videoName = $video["name"];
						$videoThumbnail = $video["images"]["thumbnail"]["url"];
						echo "<a href='watch.php?id=$videoId>' target='_blank'>
						<div class='overlay'></div>
						<div class='overlayContent'>$videoName</div>
						<img src='$videoThumbnail' />
						</a>";
					}
					?>

				</div>
			</div>
			<?php
		}
		?>

	</div>
</body>
</html>