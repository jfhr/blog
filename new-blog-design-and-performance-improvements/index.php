<?php

$title = 'New Blog Design + Performance Improvements';
$description = 'Tl;dr this blog now has a (slightly) new design, a dark mode, and better loading performance. Also I\'m now on tumblr :D';
$date = '2022-05-29';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';

?>

<article>
    <h1>New Blog Design + Performance Improvements</h1>
    <p>
        Tl;dr this blog now has a slightly new design, a dark mode, and better loading performance. Also <a href="https://jfhrdotme.tumblr.com">I'm now on tumblr :D</a>
    </p>
    <h2>New Design</h2>
    <p>
        The blog now (finally) has a dark theme. It should turn on automatically if you have your browser or operating system set to dark mode. If <a href="mailto:me@jfhr.de?subject=something%20isn't%20working!">something isn't working let me know</a>!
    </p>
    <p>
        Also, if you have high contrast mode enabled, the theme now meets <a href="https://developer.mozilla.org/en-US/docs/Web/Accessibility/Understanding_WCAG/Perceivable/Color_contrast">WCAG guidelines for accessibility</a>. That way, people with certain types of color blindness or other conditions should have an easier time reading everything.
    </p>
    <h2>Improved Performance</h2>
    <small>(read if you're interested in html hyperoptimizations)</small>
    <ul style="list-style-type: '- '">
        <li>
            <p>
                <strong>inline styles</strong>:
                The most important CSS styles are now inlined in the HTML. That way, the browser doesn't need to wait for a second request to apply the CSS styles.
            </p>
        </li>
        <li>
            <p>
                <strong>content first</strong>:
                The content of a post now loads first, before the header and footer. The HTML looks like this:
            </p>
                    <?php echo highlight('html', '<html>
<head><!-- ... --></head>
<body>
    <main><!-- blog post - this loads first! --></main>
    <header></header>
    <footer></footer>
</body>
</html>                 
'); ?>
            <p>The header and footer have <code>position: fixed</code> and the main element has top and bottom margins to make sure it's correctly positioned right away and there's no layout shift.</p>
        </li>
        <li>
            <p>
                <strong>no bootstrap</strong>:
                I've removed the <code>bootstrap</code> and <code>bootstrap-icons</code> dependencies. Icons are now inline SVG and the CSS is all hand-written!
            </p>
        </li>
        <li>
            <p>
                <strong>server-side code highlighting</strong>:
                I've removed the <code>highlight.js</code> dependency. Code highlighting now happens on the server. That also means that code highlighting now works for users with JavaScript disabled!
            </p>
        </li>
        <li>
            <p>
                <strong>more preloading</strong>:
                Every blog post is now its own PHP file, which means I can set custom <code>link rel="preload"</code> headers. That way, images and other resources that appear only in one post can also be preloaded!
            </p>
        </li>
    </ul>
</article>

<?php

require_once __DIR__ . '/../.end.php';
