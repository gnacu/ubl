<?php

header('Location: https://duckduckgo.com/?q=site%3Awww.c64os.com+'.urlencode($_GET["q"]));

echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>302 Found</title>
</head><body>
<h1>Found</h1>
<p>The document has moved <a href="https://duckduckgo.com/?q=site%3Awww.c64os.com+'.urlencode($_GET["q"]).'">here</a>.</p>
</body></html>';