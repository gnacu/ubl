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
			"Title: ".$feed->channel->title.$separator.
			"Link: ".$feed->channel->link.$separator.
			"Desc: ".$feed->channel->description.$separator.
			"Entries: ".count($feed->channel->item).$separator
		);
	break;
	case "titles":
		for($i=0;$i<count($feed->channel->item);$i++)
			print($i.": ".$feed->channel->item[$i]->title.$separator);
	break;
	case "entry":
		$entry = $_GET["entry"];
		print(
			"Title: ".$feed->channel->item[$entry]->title.$separator.
			"Date: ".$feed->channel->item[$entry]->pubDate.$separator.
			"Desc: ".$feed->channel->item[$entry]->description.$separator
		);
	break;
}
