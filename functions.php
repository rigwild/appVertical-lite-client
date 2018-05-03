<?php

/*
login to appVertical and grab response
if $getAllInfos = false -> return only the token
if $getAllInfos = true  -> return full account data
*/
function login($username = "", $password = "", $getAllInfos = false) {
	$post = "{\"login\":\"$username\",\"password\":\"$password\"}";

	if ($username == "" || $password = "") return null;	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.appvertical.com/api/login/authenticate");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$headers = array();
	$headers[] = "Accept: application/json, text/plain, */*";
	$headers[] = "Content-Type: application/json;charset=utf-8";
	$headers[] = "Host: api.appvertical.com";
	$headers[] = "User-Agent: okhttp/3.6.0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close ($ch);
	$result = json_decode($result, true);

	if ($getAllInfos) return $result;
	else return $result["token"];
}

/*
grab appVertical homepage content
return null if no token inserted
*/
function getHome($token = "") {
	if ($token == "") return null;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.appvertical.com/api/playlists?page=1&limit=9999999");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$headers = array();
	$headers[] = "Accept: application/json, text/plain, */*";
	$headers[] = "X-Access-Token: ".$token;
	$headers[] = "Host: api.appvertical.com";
	$headers[] = "User-Agent: okhttp/3.6.0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close ($ch);
	return json_decode($result, true);
}

/*
return the url of a video id
if $getAllInfos = false -> return url only
if $getAllInfos = true  -> return full video infos
*/
function getVideo($token = "", $videoId = "", $getAllInfos = false) {
	if ($token == "" || $videoId == "") return null;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.appvertical.com/api/videos/".$videoId);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$headers = array();
	$headers[] = "Accept: application/json, text/plain, */*";
	$headers[] = "X-Access-Token: ".$token;
	$headers[] = "Host: api.appvertical.com";
	$headers[] = "User-Agent: okhttp/3.6.0";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close ($ch);
	$result = json_decode($result, true);
	if ($getAllInfos) return $result;
	else return $result["hdPath"];
}

/*
grab appVertical homepage content, get all videos by series
grab name, url, description, thumbnail
(Take some time because 1 request per video to get each url)
*/
function getHomeVideoData($token = "") {
	if ($token == "") return null;

	$home = getHome($token);
	$videoData = [];
	foreach ($home["results"] as $key => $value) {
		$seriesName = $value["name"];
		$videoData[$seriesName] = [];
		foreach ($home["results"][$key]["videos"] as $keyy => $valuee) {
			$temp = getVideo($token, $valuee["_id"], true);
			/*Vertical anti-bot blocks you if there's sooo much request, so output "" if it can't get retrieved.*/
			$videoInfo = [];
			$videoInfo["id"] 			= (isset($temp["_id"])) ? $temp["_id"] : "";
			$videoInfo["name"] 			= (isset($temp["name"])) ? $temp["name"] : "";
			$videoInfo["description"] 	= (isset($temp["description"])) ? $temp["description"] : "";
			$videoInfo["thumbnail"] 	= (isset($temp["images"]["large"]["url"])) ? $temp["images"]["large"]["url"] : "";
			$videoInfo["url"] 			= (isset($temp["hdPath"])) ? $temp["hdPath"] : "";

			array_push($videoData[$seriesName], $videoInfo);
		}
	}
	return $videoData;
}

/*
Save any var from PHP to a JSON file
*/
function saveJsonToFile($data, $fileName, $prettyPrint = false) {
	if ($prettyPrint) {
		if (($data = json_encode($data, JSON_PRETTY_PRINT)) != false) {
			file_put_contents($fileName, $data);
			return true;
		}
	}
	else {
		if (($data = json_encode($data)) != false) {
			file_put_contents($fileName, $data);
			return true;
		}
	}
	file_put_contents($fileName, "Error when converting to JSON.");
	return false;
}

/*
Get PHP var from JSON file
*/
function getPhpFromFile($fileName) {
	if (file_exists($fileName)) {
		$data = file_get_contents($fileName);
		if (($data = json_decode($data, true)) != false)
			return $data;
	}
	return null;
}

//https://admin.appvertical.com/api/videos?limit=9999999

?>