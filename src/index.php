<?php

define("MAX_HOME_POSTS",    15);
define("MAX_HOME_FULLPOSTS",10);

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
	$info = json_decode($info,true);

	if($j < MAX_HOME_FULLPOSTS) {
		$body = file_get_contents("posts/".$i.".html");

		$postContent = "
			<a name='".$info["slug"]."' class='slug'><div class='date'>".$info["date"]."<em>".$info["type"]."</em><hr></div></a>
			<h3><a href='post?p=".$i."#post' class='title'>".$info["title"]."</a></h3>

			<div class='comments'><a href='post?p=".$i."#disqus_thread' data-disqus-identifier='".$info["slug"]."'></a></div>

			".$body."
		";
	} 
	
	else {
		$postContent = "
			<a name='".$info["slug"]."' class='slug'><div class='date'>".$info["date"]."<em>".$info["type"]."</em><hr></div></a>
			<h3><a href='post?p=".$i."#post' class='title'>".$info["title"]."</a></h3>
		";

		//Injects a header above these post summaries
		if($j == MAX_HOME_FULLPOSTS) {
			$postContent = "
				<a name='olderposts' class='slug'><div class='date'>Older Posts<em>Click titles to see full content</em><hr></div></a>
				<p>
					The home page shows the full content of the 10 most recent posts.<br>
					Below are the titles of 5 posts older than the most recent 10.<br>
					Click their titles to view the complete post and read and leave comments.
				</p>
			".$postContent;
		}
	}
	
	$posts[] = $postContent;
}


$posts[] = "
	<a name='viewarchive' class='slug'><div class='date'>Archive<hr></div></a>
	<h3><a href='archive#post' class='title'>Full Archive of Past Posts…</a></h3>
";

$template = str_replace("<!--{post}-->",implode("\n\n",$posts),$template);

print($template);

