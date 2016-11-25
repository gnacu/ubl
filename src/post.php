<?php

$template = file_get_contents("template-main.html");

$post = $_GET["p"];

$info = file_get_contents("posts/".$post.".json");
$body = file_get_contents("posts/".$post.".html");

$info = json_decode($info,true);

$postContent = "
	<h3><a href='/'>See All Posts</a></h3>

	<a name='".$info["slug"]."' class='slug'><div class='date'>".$info["date"]."<em>".$info["type"]."</em><hr></div></a>
	<h3>".$info["title"]."</h3>

	".$body."
	
	<div id='disqus_thread'></div>

	<script>
		var disqus_config = function () {
			this.page.url 			 = 'http://www.c64os.com/post?p=".$post."';
			this.page.identifier = '".$info["slug"]."';
		};

		(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = '//c64os.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
		})();
	</script>
	
	<noscript>
		Please enable JavaScript to view the <a href='https://disqus.com/?ref_noscript'>comments powered by Disqus.</a>
	</noscript>
";

$template = str_replace("<!--{post}-->",$postContent,$template);

print($template);

