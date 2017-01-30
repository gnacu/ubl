<?php

header('Content-Type: text/xml');

$title   		 = "C64 OS";
$feedURL 		 = "http://www.c64os.com/feed";
$linkURL     = "http://www.c64os.com/post?p=";
$description = "A blog about making a C64 useful in a modern world. Tracks the development progress of C64 OS, an event driven and network oriented unitasking OS for stock C64.";
$logoURL     = "http://c64os.com/resources/logo-rss-c64os.png";
$logoWidth   = "144";
$logoHeight  = "48";
$author			 = "some@address.com (Gregory Nacu)";

$postsInfo = file_get_contents("posts/index.json");
$postsInfo = json_decode($postsInfo,true);

$posts = array();

for($i=$postsInfo["count"];$i>0;$i--) {
	$info = file_get_contents("posts/".$i.".json");
	$info = json_decode($info,true);

	$articleDesc = trim(preg_replace('/\s\s+/', ' ', strip_tags(file_get_contents("posts/".$i.".html",false,null,0,200))));

	$postContent = "
		<item>
			<title>".$info["title"]."</title>
			<link>".$linkURL.$i."#post</link>
			<author>".$author."</author>
			<pubDate>".gmdate(DATE_RSS,strtotime($info["date"]))."</pubDate>
			<category>".$info["type"]."</category>
			<description><![CDATA[ ".$articleDesc." ]]></description>
			<guid>".$linkURL.$i."</guid>
		</item>
	";
	
	$posts[] = $postContent;
}

// Output XML (RSS)
print('<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>'.$title.'</title>
		<link>'.$feedURL.'</link>
		<atom:link href="'.$feedURL.'" rel="self" type="application/rss+xml" />
		<description>'.$description.'</description>
		<language>en-us</language>
		<image>
			<title>'.$title.'</title>
			<url>'.$logoURL.'</url>
			<link>'.$feedURL.'</link>
			<width>'.$logoWidth.'</width>
			<height>'.$logoHeight.'</height>
		</image>'.
		
		implode("",$posts).'
		
	</channel>
</rss>');

