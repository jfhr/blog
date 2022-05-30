<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'The DeconstruCT.F 2021';
$description = "I played in the DeconstruCT.F 2021 with ps1ttacus! It's a little late, but these are my writeups for the web challenges I solved.";
$date = '2021-10-24';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>The DeconstruCT.F 2021</h1><p>I played in the DeconstruCT.F 2021 with <a href="https://ps1ttacus.de">ps1ttacus</a>! It's a little late, but these are my writeups for the web challenges I solved.</p><h2>Never gonna lie to you (243 points)</h2><p>The page linked in this challenge had a <code>robots.txt</code> file with the following content: </p><?php echo highlight('http', "User-agent:*
Disallow:/static/
Disallow:/never_gonna_give_you_up/
"); ?><p>The first two lines are nothing unusual, but the last one was interesting. When visiting the path <code>/never_gonna_give_you_up/</code>, I got the following HTML code:</p><?php echo highlight('html', '<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- omitted... -->
    </head>
    <body id="page-top">
        <!-- omitted... -->
	<div class="container">
		<div class="row">
			<form class="column" action="/never_gonna_let_you_down" method="post">
				<label> Username: </label>
				<input type="text" name="username">
				<label> Password: </label>
				<input type="password" name="password">
			</form>
       </footer><!-- (sic!) -->
        <!-- omitted... -->
    </body>
</html>'); ?><p>There was a login form that would be POSTed to <code>/never_gonna_let_you_down</code>. And what's the first thing you do when you find a login form? You try an SQL injection. I sent the following request:</p><?php echo highlight('http', "POST /never_gonna_let_you_down
username=
password=' OR 1=1; --
"); ?><p>And it worked! That request returned the flag.</p><h2>Curly Fries 1 (248 points)</h2><p>This one linked to a page that looked like this:</p><div><picture>
    <source srcset="/curly-fries-1.avif" type="image/avif">
    <source srcset="/curly-fries-1.jxl" type="image/jxl">
    <img src="/curly-fries-1.jpeg" alt="Screenshot of a Webpage showing the Swedish flag in the background and four pictures in the foreground: The top left is of some guy I don't know, the top right is the logo of the Swedish clothing retail company H&M, the bottom left is the logo of the Swedish furniture store IKEA, the bottom right is the Swedish YouTuber PewDiePie" width="551" height="388" class="border">
</picture></div><p>I don't know who the guy in the top left is, but the other images were all clearly related to Sweden. I requested the page again, this time with the <code>Accept-Language</code> header set to <code>sv-SE</code> (which stands for Swedish). Then I immediately got the flag.</p><h2>Curly Fries 3 (600 points)</h2><p>This one was similar to Curly Fries 1 - you had to change your HTTP request headers and parameters.</p><p>When I loaded the page at first, I got a <?php echo highlight('http', "405: Method not allowed"); ?> response. So, I tried again with a <code>POST</code> request.</p><p>This time, I got a response with the following content: <?php echo highlight('plaintext', "perhaps try Googling me instead?"); ?> So I set the <code>Referer</code> header to <code>https://www.google.com</code>, which suggests that I came from a google search (btw, <a href="https://stackoverflow.com/questions/3087626/was-the-misspelling-of-the-http-field-name-referer-intentional">yes, it's really spelled that way</a>).</p><p>Now, the response said <?php echo highlight('plaintext', "did you attend that lovely dinner party Hosted by dscvit?"); ?> This was a hint that I should set the <code>Host</code> header to <code>dscvit</code>.</p><p>Next, I got a little poem: <?php echo highlight('plaintext', "potates and carrots are my friends, milk and Cookies will be my end"); ?>This time, the response also contained an additional header:<?php echo highlight('http', "Set-Cookie: user=anon"); ?>However, just sending <code>Cookie: user=anon</code> with my request wasn't enough. The correct value was something else.</p><p>Now, someone who goes outside occasionally might have known that potatoes and carrots are both <i>root</i> vegetables. But I didn't, so I had to use guessing to find that the correct value to send was <code>Cookie: user=root</code>.</p><p>The next response was: <?php echo highlight('plaintext', "JFATHER, JMOTHER, JDAUGHTER, ____?"); ?>Obviously, this is a reference to <code>JSON</code>. I added a <code>Content-Type: application/json</code> header and an empty JSON body to my request.</p><p>Now, the response was also a JSON object:<?php echo highlight('javascript', "{'error': {'messi': 'required'}}"); ?> Suggesting that the server was expecting a property called <code>"messi"</code>. When I sent <code>{"messi": "foo"}</code>, I got back: <?php echo highlight('javascript', "{'error': {'messi': 'which club am i at?'}}"); ?>Google told me that Messi is a soccer player currently playing for Paris Saint-Germain. So, I sent the final request with <code>{"messi":"Paris Saint-Germain"}</code>, and got the flag.</p>        </article>


<?php
require_once __DIR__ . '/../.end.php';
