<?php

$feed = implode(file($_GET["feed"]));
$xml  = simplexml_load_string($feed);
$json = json_encode($xml);
$feed = json_decode($json);

$action = "meta";
if($_GET["action"])
	$action = $_GET["action"];

$separator = "<br>";

switch($action) {
	case "meta":
		print(
			"Title: ".$feed->title.$separator.
			"Subtitle: ".$feed->subtitle.$separator.
			"Id: ".$feed->id.$separator.
			"Updated: ".$feed->updated.$separator.
			"Rights: ".$feed->rights.$separator.
			"Entries: ".count($feed->entry).$separator
		);
	break;
	case "titles":
		for($i=0;$i<count($feed->entry);$i++)
			print($i.": ".$feed->entry[$i]->title.$separator);
	break;
}

//print($json);