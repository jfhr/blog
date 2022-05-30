<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'CC 0';
$date = '2021-05-21';

require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>CC Zero</h1>
    <p>This blog is published under the terms of Creative Commons Zero. The full legal text can be found at <a href="http://creativecommons.org/licenses/zero/1.0/">http://creativecommons.org/licenses/zero/1.0/</a>. This post exists to answer a few questions:</p>
    <ul>
        <li>What is covered?</li>
        <li>What <strong>isn't</strong> covered?</li>
    </ul>
    <p>And most importantly:</p>
    <ul>
        <li>Why CC 0?</li>
    </ul>
    <h2>What is covered?</h2>
    <p><strong>Everything that I write on this blog</strong> is covered under CC 0, unless specified otherwise. That means: </p>
    <ul>
        <li>The text of blog posts</li>
        <li>The content of code snippets</li>
        <li>Any custom content, such as interactive elements</li>
    </ul>
    <h2>What isn't covered?</h2>
    <p><strong>Anything that I didn't make myself</strong>. That means, among other things:</p>
    <ul>
        <li>Any stylesheets, such as bootstrap or highlight.js. These are generally published under their own license.</li>
        <li>Any scripts, such as jQuery, popper, and more. There are generally published under their own license.</li>
        <li>Any icons. I use Bootstrap Icons which also have their own license.  </li>
        <li>Any extra information transferred when you use the website, e.g. HTML Headers, connection information, all that stuff.</li>
    </ul>
    <p>...basically, anything that would go away if you copied a blog post into notepad.</p>
    <h2>Why CC 0?</h2>
    <p>CC 0 puts stuff under the public domain, which means that no copyright rules apply. Anyone is free to do whatever they want, including copying, changing, selling, etc. If you find something useful in a post, like a code snippet, you can freely copy it. You don't have to worry about licensing, about giving me credit, about patent issues, any of that pesky stuff. Just go ahead and use it. If it helps you a lot, feel free to <a href="mailto:me@jfhr.de">let me know</a> :)</p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
