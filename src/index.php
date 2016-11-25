<?php

define("MAX_HOME_POSTS",10);

$template = file_get_contents("template-main.html");

$postsInfo = file_get_contents("posts/index.json");
$postsInfo = json_decode($postsInfo,true);

$postCount = $postsInfo["count"];

//This is to see a post in progress that hasn't been officially
//published via incrementing the /posts/index.json count.
if(isset($_GET["preview"]))
	$postCount++;

$posts = array();

for($i=$postCount,$j=0;$i>0&&$j<MAX_HOME_POSTS;$i--,$j++) {
	$info = file_get_contents("posts/".$i.".json");
	$body = file_get_contents("posts/".$i.".html");

	$info = json_decode($info,true);

	$postContent = "
		<a name='".$info["slug"]."' class='slug'><div class='date'>".$info["date"]."<em>".$info["type"]."</em><hr></div></a>
		<h3><a href='post?p=".$i."#post' class='title'>".$info["title"]."</a></h3>

		<div class='comments'><a href='post?p=".$i."#disqus_thread' data-disqus-identifier='".$info["slug"]."'></a></div>

		".$body."
	";
	
	$posts[] = $postContent;
}


$posts[] = "
	<a name='viewarchive' class='slug'><div class='date'>Archive<hr></div></a>
	<h3><a href='archive#post' class='title'>View Archived Posts</a></h3>
";

$template = str_replace("<!--{post}-->",implode("\n\n",$posts),$template);

print($template);

