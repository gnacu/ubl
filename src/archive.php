<?php

$template = file_get_contents("template-main.html");

$postsInfo = file_get_contents("posts/index.json");
$postsInfo = json_decode($postsInfo,true);

$prePosts = "
	<h3><a href='/'>Return to Home Page</a></h3>

	<form action='search' method='get'>
		<input type='text' name='q' placeholder='Search c64os.com'> <input type='submit' value='Search'>
	</form>
";

$posts = array();

for($i=$postsInfo["count"];$i>0;$i--) {
	$info = file_get_contents("posts/".$i.".json");
	$info = json_decode($info,true);

	$postContent = "
		<a name='".$info["slug"]."' class='slug'><div class='date'>".$info["date"]."<em>".$info["type"]."</em><hr></div></a>
		<h3><a href='post?p=".$i."#post' class='title'>".$info["title"]."</a></h3>
	";
	
	$posts[] = $postContent;
}

$template = str_replace("<!--{post}-->",$prePosts.implode("\n\n",$posts),$template);

print($template);

