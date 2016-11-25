# ubl
Ultralight Blogging Platform

##About

I wanted to start a blog, but I'm a developer and I have complaints about every existing blogging platform. What I really wanted was something incredibly simple. Something so simple that every line of code played some necessary role in making my site what I wanted it to be, without any line of code that's unnecessary.

Initially, it began with a single index.html file, a folder for some images and a css file, a folder for some scripts and a handful of useful scripts for adding a bit of spice. New blog posts were added simply by editing the main index.html file and putting in a new block of HTML.

After 7 or so lengthy posts, I recognized that this was not going to scale. So I plunged in and created what I now present to the world as UBL, Ultralight Blogging Platform.

It's got lots of useful features, and it's got absolutely nothing that isn't essential. In a word, it's ultralight.

##Features

* Templates written in pure HTML
* Dynamic homepage showing most recent X articles
* Post specific view with permanent URL
* Archive view with links to all posts
* Preview in situ one post before publishing
* DuckDuckGo search form in page footer and top of archive
* Disqus comments embedded after post in post view
* Comments count and link for each post on homepage
* Lazy/late loading images
* Image zoom
* Bigfoot footnotes
* PHP, Apache, and NO Database

##Technical Overview

I've included one template file. But you can create additional ones very simply. The template file has a header, left sidebar, and footer. It has one "substitution" variable. This is a token of the form {post} inside HTML comments. Thus, the template file is _pure_ HTML, it has no PHP strewn throughout it. Because there is only one template, the homepage, post and archive 
views all load it. If you wanted to have an alternative template for the post and/or archive views, simply make a different
template and reference that at the top of archive.php and post.php.

System requirements are unimaginably low. The only functions PHP needs to support are: file_get_contents, str_replace and json_decode. That's _literally_ all PHP needs. It doesn't need a database. Basically, any breadbox installation of PHP is probably more than enough.

Posts are stored in a /posts folder. Each post consists of two files, x.json and x.html. Where x is the post number, starting at 1 and going up without limit to however many posts you may make. The x.json file contains a very small JSON encoded object with the following properties: slug, date, title, type. The slug is a human-readable, unchanging identifier for the post, used by Disqus for uniquely identifing the post. Date is a human-readable, aka preformatted, date string. Title is the title of the article. And type is a like a single tag for categorizing your posts. The x.html file contains an HTML fragment, usually a series of p tags, with some images and an optional ol footnotes list at the bottom. It is the body of the post.

In the /posts folder is also an index.json file. This file contains a JSON object with just one property, count. It must be set to the largest post number you have published.

##How it works

When you want to make a post, you simply add a new x.json and x.html file to the /posts folder. Set the slug, date, title and type in the json file, and type your post in the html file. Lightly formated with paragraphs, cites, pres, imgs, or whatever you want, but without any surrounding containers.

When you load the main domain and index.php is loaded, it reads in the template file, then it reads in /posts/index.json which it decodes to get the total number of posts. It then loops in reverse order from the largest post number down, stopping after X posts, which is configurable as a define at the top of index.php. For each post number it reads in the json file, and formats a header for the post. Then it loads in the html body of the post. After reading in and formating X number of posts, if there are more posts it will add one more pseudo-post header with a link to the archive to view more. It then replaces the {post} token in the middle of the template file with all the dynamically generated content above and prints the whole thing to the browser.

The template file includes the javascript to replace footnote links with bigfoot footnote popovers, to apply the image zoom to images correctly marked, and to add the Disqus comment counts to each article. Each article title links to /post?p=x where x is that post's number.

An .htaccess file is found in the root folder that will add the .php ending to filenames that are missing it. This allows the link to /post to load the /post.php file. It makes the URL and links look a little cleaner and doesn't expose to the world that you are a dirty php-using animal.

Post.php takes the ?p=x GET variable, and uses it to load the json and html file from /posts for just that number. It formats a header just as the index.php file did, and puts in the body of just that one post. It then includes the javascript necessary to invoke Disqus at the bottom of the post. And it puts the slug of the post and the post's canonical URL into the Disqus config settings for this article. And it then exports this dynamic content into the template. An alternative template here can be used if desired.

Archive.php does almost the same thing as index.php, except it excludes the post bodies, and it doesn't limit to the most recent X articles.

The search form that is included by the main template in the footer of the page, and by archive.php before the list of posts, is also incredibly simple. It has one text field and a search button. And it submits to /search, aka search.php. This file does nothing except spit out a location: header to redirect to duckduckgo.com with the appropriate site: parameter. 

##Conclusion

And that is it folks. Because the images are lazy loading, you can puts lots of images in your posts and it isn't going to tax your server too much. If you need to toss the images in an S3 bucket, and or source your videos from Youtube or Vimeo. No database is required, because the posts are stored as files in the /posts folder. The PHP is super lightweight, it is used as a minimum requirement to loop over the post files and lightly format them and then string substitute them into the otherwise pure HTML template. 

Disqus handles all the comments and does a splendid job of that. And DuckDuckGo handles all the fulltext indexing of your content and it too does a splendid job of that.
