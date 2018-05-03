<?php

function login($username = "", $password = "", $getAllInfos = false) {
	//login to appVertical and grab response
	//if $getAllInfos = false -> return only the token
	//if $getAllInfos = true  -> return full account data
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

function getHome($token = "") {
	//grab appVertical homepage content
	//return null if no token inserted
	if ($token == "") return null;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.appvertical.com/api/playlists?page=1&limit=5");
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

function getVideo($token = "", $videoId = "", $getAllInfos = false) {
	//return the url of a video id
	//if $getAllInfos = false -> return url only
	//if $getAllInfos = true  -> return full video infos
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

function getHomeVideoData($token = "") {
	//grab appVertical homepage content, get all videos by series
	//grab name, url, description, thumbnail
	//(Take some time because 1 request per video to get each url)
	if ($token == "") return null;

	$home = getHome($token);
	$videoData = [];
	foreach ($home["results"] as $key => $value) {
		$seriesName = $value["name"];
		$videoData[$seriesName] = [];
		foreach ($home["results"][$key]["videos"] as $keyy => $valuee) {
			$temp = getVideo($token, $valuee["_id"], true);

			$videoInfo = [];
			$videoInfo["id"] = dontReturnNull($temp["_id"]);
			$videoInfo["name"] = dontReturnNull($temp["name"]);
			$videoInfo["description"] = dontReturnNull($temp["description"]);
			$videoInfo["thumbnail"] = dontReturnNull($temp["images"]["large"]["url"]);
			$videoInfo["url"] = dontReturnNull($temp["hdPath"]);
			array_push($videoData[$seriesName], $videoInfo);
		}
	}
	return $videoData;
}

/*Return if the content is null or not*/
function dontReturnNull($data) {
	if ($data == null)
		return "";
	else
		return $data;
}
?>