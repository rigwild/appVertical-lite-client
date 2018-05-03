<?php
require '../functions.php';

$username = "testazerty";
$password = "testazerty";
$token = login($username, $password);
$linkList = getHomeVideoData($token);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Vertical - Lite client</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
	<style type="text/css">

		html {
			zoom: 175%;
		}
		body {
			font-family: 'Poppins', sans-serif;
			background-color: #0f0f0f;
			margin: 0px;
		}
		table {
			border-spacing: 0;
			border-collapse: collapse;
			border: 0;
			padding: 0;
		}
		table tr td a {
			display:block;
			height:100%;
			width:100%;
			text-decoration: none;
			color:white;
		}
		img {
			display: block;
		}
		td {
			padding: 0px;
			margin: 0px;
		}
		.line {
			height: 100%;
			padding: 0px;
			margin: 0px;
			
		}
		.legend {
			padding-left: 15px;
			padding-right: 15px;
			width:500px;
			color:white;
		}
		.title {
			font-size:20px;
			font-weight: bold;
		}
		.author {

		}
		.description {
			font-size:18px;
		}


	</style>
</head>
<body>

	<?php

	//backup old file
				$current = file_get_contents("links.txt");
				file_put_contents("links_old.txt", $current);

				$current = file_get_contents("links_pics.txt");
				file_put_contents("links_pics_old.txt", $current);

				$current_name = file_get_contents("links_name.txt");
				file_put_contents("links_name_old.txt", $current_name);

				//reset new file
				file_put_contents("links.txt", "");
				file_put_contents("links_pics.txt", "");
				file_put_contents("links_name.txt", "");


	//Get all videos IDs
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://admin.appvertical.com/api/videos?limit=9999999");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = "Accept: application/json, text/plain, */*";
	$headers[] = "X-Access-Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY3RpdmF0aW9uIjoiM21vd2JqNnNic2NsMSIsImJpcnRoZGF0ZSI6IjE5ODktMTItMzFUMjM6MDA6MDAuMDAwWiIsInVzZXJuYW1lIjoiYXNzc0UiLCJsYXN0bmFtZSI6IkVnZGp6c2oiLCJmaXJzdG5hbWUiOiJBc3NzIiwiZW1haWwiOiJhemVydHlAY3V2b3guZGUiLCJfaWQiOiI1OWEwODc3NzU4OTI2MTA0OGI5OGI5NWEiLCJ1cGRhdGVkX2F0IjoiMjAxNy0wOC0yNVQyMDoyNDoyMy4yMjRaIiwiY3JlYXRlZF9hdCI6IjIwMTctMDgtMjVUMjA6MjQ6MjMuMjIwWiIsImZvbGxvd2VycyI6MCwiZm9sbG93cyI6MCwiZ2VuZGVyIjoib3RoZXIiLCJpbWFnZXMiOnsiYmFja2dyb3VuZCI6eyJ1cmwiOiJodHRwczovL2FkbWluLmFwcHZlcnRpY2FsLmNvbS9wdWJsaWMvYXNzZXRzL2ltYWdlcy9kZWZhdWx0X2JhY2tncm91bmQuanBnIiwid2lkdGgiOjE5MjAsImhlaWdodCI6MTA4MH0sImF2YXRhciI6eyJ1cmwiOiJodHRwczovL2FkbWluLmFwcHZlcnRpY2FsLmNvbS9wdWJsaWMvYXNzZXRzL2ltYWdlcy9kZWZhdWx0X2F2YXRhci5qcGciLCJ3aWR0aCI6MTUwLCJoZWlnaHQiOjE1MH19LCJsb2NhbGUiOiIiLCJyb2xlIjoiZ3Vlc3QiLCJmdWxsbmFtZSI6IkFzc3MgRWdkanpzaiIsImlhdCI6MTUwMzY5MjY2MywiZXhwIjoxNTA4ODc2NjYzfQ.DUG8CLQNbVVIPhCwChaYGPx6tJqbR8MQXEHrSDpnh4Y";
	$headers[] = "Host: admin.appvertical.com";
	$headers[] = "Cookie: connect.sid=s%3AQKdnd0FnXhzbee4Ofah_hFxmOIdDff9R.9Oe0b7h%2BODL2l5sjIviPkWx7m%2B%2B3z%2BHVi6pmdS5A7Cw";
	$headers[] = "User-Agent: okhttp/3.6.0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);

	$json = json_decode($result, true);

//var_dump($result);

	//If videos IDs have been grabbed, continue.
	if (count($json["results"]) > 0) {
		$videos_id = [];
		foreach ($json["results"] as $key => $value) {
			array_push($videos_id, $value["_id"]);
		}
		echo "<table style='margin:0 auto;'>";
		foreach ($videos_id as $key => $value) {
			if ($key !== -1) {

				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, "https://admin.appvertical.com/api/videos/".$value);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

				$headers = array();
				$headers[] = "Accept: application/json, text/plain, */*";
				$headers[] = "X-Access-Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY3RpdmF0aW9uIjoiM21vd2JqNnNic2NsMSIsImJpcnRoZGF0ZSI6IjE5ODktMTItMzFUMjM6MDA6MDAuMDAwWiIsInVzZXJuYW1lIjoiYXNzc0UiLCJsYXN0bmFtZSI6IkVnZGp6c2oiLCJmaXJzdG5hbWUiOiJBc3NzIiwiZW1haWwiOiJhemVydHlAY3V2b3guZGUiLCJfaWQiOiI1OWEwODc3NzU4OTI2MTA0OGI5OGI5NWEiLCJ1cGRhdGVkX2F0IjoiMjAxNy0wOC0yNVQyMDoyNDoyMy4yMjRaIiwiY3JlYXRlZF9hdCI6IjIwMTctMDgtMjVUMjA6MjQ6MjMuMjIwWiIsImZvbGxvd2VycyI6MCwiZm9sbG93cyI6MCwiZ2VuZGVyIjoib3RoZXIiLCJpbWFnZXMiOnsiYmFja2dyb3VuZCI6eyJ1cmwiOiJodHRwczovL2FkbWluLmFwcHZlcnRpY2FsLmNvbS9wdWJsaWMvYXNzZXRzL2ltYWdlcy9kZWZhdWx0X2JhY2tncm91bmQuanBnIiwid2lkdGgiOjE5MjAsImhlaWdodCI6MTA4MH0sImF2YXRhciI6eyJ1cmwiOiJodHRwczovL2FkbWluLmFwcHZlcnRpY2FsLmNvbS9wdWJsaWMvYXNzZXRzL2ltYWdlcy9kZWZhdWx0X2F2YXRhci5qcGciLCJ3aWR0aCI6MTUwLCJoZWlnaHQiOjE1MH19LCJsb2NhbGUiOiIiLCJyb2xlIjoiZ3Vlc3QiLCJmdWxsbmFtZSI6IkFzc3MgRWdkanpzaiIsImlhdCI6MTUwMzY5MjY2MywiZXhwIjoxNTA4ODc2NjYzfQ.DUG8CLQNbVVIPhCwChaYGPx6tJqbR8MQXEHrSDpnh4Y";
				$headers[] = "Host: admin.appvertical.com";
				$headers[] = "Cookie: connect.sid=s%3AQKdnd0FnXhzbee4Ofah_hFxmOIdDff9R.9Oe0b7h%2BODL2l5sjIviPkWx7m%2B%2B3z%2BHVi6pmdS5A7Cw";
				$headers[] = "User-Agent: okhttp/3.6.0";
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close ($ch);

				$json = json_decode($result, true);

				//var_dump($result);

				echo "<tr class='line' onmouseover='this.style.backgroundColor  = \"#565656\"' onmouseout='this.style.backgroundColor  = \"transparent\"'><td><a href='".$json["hdPath"]."' target='_blank'><img width='150' src='".$json["images"]["large"]["url"]."'></a></td>";
				echo "<td class='legend'><span class='title'>".$json["name"]."</span><br><span class='author'>@".$json["user"]["username"]."</span><br><br><span class='description'>".$json["description"]."</span></td>";

				echo "</tr>";

				//script to get all videos title descriptions and links
				$current = file_get_contents("links.txt");
				file_put_contents("links.txt", $current.$json["hdPath"]."\n");

				$current = file_get_contents("links_pics.txt");
				file_put_contents("links_pics.txt", $current.$json["images"]["large"]["url"]."\n");

				$current_name = file_get_contents("links_name.txt");
				file_put_contents("links_name.txt", $current_name.$json["name"]."\n".$json["description"]."\n".$json["user"]["username"]."\n".$json["images"]["large"]["url"]."\n".$json["hdPath"]."\n\n");

			}
		}
		echo "</table>";
	}
	else {
		echo "<h1 style='color:white;'>Echec de récupération des vidéos.</h1>";
	}
	?>


</body>
</html>