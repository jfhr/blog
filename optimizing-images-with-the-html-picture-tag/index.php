<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Optimizing images with the HTML picture tag';
$description = 'If you have a website, you probably want it to be fast. One common reason why websites aren’t fast is because they have a lot of images. Images take time to load. Generally, the browser will load your website, find out that it contains a bunch of images, and start loading those as well. You can optimize that with HTTP/2 Server Push. Another optimization is to simply make your images smaller, without sacrificing quality - that’s what this post is about.';
$date = '2022-03-20';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>Optimizing images with the HTML &lt;picture&gt; tag</h1>

    <p>If you have a website, you probably want it to be fast. Websites that load fast are more fun. They’re also higher ranked on Google. If you make money from your website, chances are you’ll make more money the faster it loads. Faster websites also use less energy. </p>

    <p>One common reason why websites <em>aren’t</em> fast is because they have a lot of images. Images take time to load. Generally, the browser will load your website, find out that it contains a bunch of images, and start loading those as well. You can optimize that with <a target="_blank" href="https://jfhr.me/http-2-server-push">HTTP/2 Server Push</a>. Another optimization is to simply make your images smaller, without sacrificing quality - that’s what this post is about.</p>

    <p><a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types">MDN has a great primer on different image types</a> if you’re interested in that. Tl;dr: PNG, JPEG and GIF are supported by pretty much every browser. But newer formats, like AVIF, WEBP, and JPEG XL are often more efficient (yeah, JPEG XL images are smaller than JPEG. don’t ask me.) The same picture can be 20%-90% smaller with AVIF compared to PNG, without sacrificing quality.</p>

    <p>In my experience AVIF tends to perform best. But I’d recommend trying all the formats for each image and seeing which ends up with the smallest file size!</p>

    <h2>#1 Convert images to another format</h2>

    <p>I like using <a target="_blank" href="https://imagemagick.org/index.php">imagemagick</a> for that, because it’s simple and cross-platform:</p>

    <?php highlight('bash', 'magick convert image.jpg image.avif'); ?>

    <p>You can do that for every image/format combination. There’s also <a target="_blank" href="https://avif.io">avif.io</a> for AVIF specifically.</p>

    <h2>#2 Including multiple formats in HTML</h2>

    <p>This is important because some browser don’t support all the new image formats, and no, it’s not just Internet Explorer. For example, <a target="_blank" href="https://caniuse.com/?search=avif">Safari currently doesn’t support AVIF</a> and <a target="_blank" href="https://caniuse.com/?search=webp">WebP only works on MacOS 11+</a>. <a target="_blank" href="https://caniuse.com/?search=jpeg xl">JPEG XL doesn’t seem to work anywhere unless you use special flags</a>. I’d still recommend including JPEG XL versions of your images, because chances are that browser support will come eventually.</p>

    <picture class="invert">
        <source srcset="https://jfhr.me/your-browser-supports.avif" type="image/avif">
        <source srcset="https://jfhr.me/your-browser-supports.jxl" type="image/jxl">
        <source srcset="https://jfhr.me/your-browser-supports.webp" type="image/webp">
        <img src="https://jfhr.me/your-browser-supports.jpeg" width="400" height="100">
    </picture>

    <p class="text-secondary">You can inspect the image above to see the &lt;picture&gt; element in action</p>

    <p>Traditionally if you want to put an image in your HTML you use the <code>&lt;img&gt;</code> tag, with a single <code>src</code> attribute that points to the image URL. That’s no fun. We’ll use the <code>&lt;picture&gt;</code> tag instead, which lets us specify multiple source URLs with different MIME types. The browser will choose the first one it supports. </p>

    <p>Here’s an example (taken from <a target="_blank" href="https://jfhr.me/document.designmode">this post</a>):</p>

    <pre><code class="html hljs language-xml"><span class="hljs-tag">&lt;<span class="hljs-name">picture</span>&gt;</span>
<span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"/document.designmode.avif"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"image/avif"</span>&gt;</span>
<span class="hljs-tag">&lt;<span class="hljs-name">source</span> <span class="hljs-attr">srcset</span>=<span class="hljs-string">"/document.designmode.jxl"</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"image/jxl"</span>&gt;</span>
<span class="hljs-tag">&lt;<span class="hljs-name">img</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"/document.designmode.jpeg"</span> <span class="hljs-attr">alt</span>=<span class="hljs-string">"Screenshot on iOS with selected text, showing a popup with options to make text Bold, Italic, or Underlined"</span> <span class="hljs-attr">width</span>=<span class="hljs-string">"375"</span> <span class="hljs-attr">height</span>=<span class="hljs-string">"153"</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"border"</span>&gt;</span>
<span class="hljs-tag">&lt;/<span class="hljs-name">picture</span>&gt;</span>
</code></pre>

    <p>The first source URL is the AVIF format, because that’s the smallest one. Chrome and Firefox will use that one. Safari doesn’t support the <code>image/avif</code> MIME type, so it will skip that one. It will skip the JPEG XL version as well, and fallback to the last source, the JPEG version. Note that the last fallback URL is inside an <code>&lt;img&gt;</code> tag, while the previous one are inside <code>&lt;source&gt;</code> tags. The final <code>&lt;img&gt;</code> tag also specifies common attributes like width, height and alt text. Those attributes will apply regardless of which source the browser chooses! Browsers that don’t support the <code>&lt;picture&gt;</code> tag at all (<a target="_blank" href="https://caniuse.com/?search=picture">can you guess which one</a>?) will simply ignore it and treat the <code>&lt;img&gt;</code> tag like a normal image. </p>

    <h2>#3 Server Push for &lt;picture&gt; elements</h2>

    <p>Ok, it’s time to leave the realm of reasonable performance considerations and move on to crazy hyperoptimizations. Let’s say you followed the advice at the top and setup HTTP/2 Server Push for your images. How do you decide which image format to push to the browser, before it had an opportunity to parse your HTML on its own and decide which format it wants?</p>

    <p>I don’t think there’s a perfect answer. You simply cannot predict with 100% certainty what the browser would choose. But you can get a good approximation by parsing the User-Agent header, comparing it with an up-to-date copy of the varios caniuse tables linked above, and using that to guess which format the browser will request. I say guess because there are a lot of things that can go wrong here: Maybe the user changed their User-Agent string. Maybe they’re using a new browser version that’s not in your caniuse table. Maybe they’ve set custom flags. You never know.</p>

    <p>Here’s a simplified example in PHP so you know what I’m talking about:</p>

    <pre><code class="php hljs language-php"><span class="hljs-variable">$browser</span> = get_browser(<span class="hljs-literal">null</span>, <span class="hljs-literal">true</span>);
<span class="hljs-variable">$name</span> = <span class="hljs-variable">$browser</span>[<span class="hljs-string">'browser'</span>];
<span class="hljs-variable">$version</span> = intval(<span class="hljs-variable">$browser</span>[<span class="hljs-string">'majorver'</span>]);

<span class="hljs-comment">// Firefox &gt;= 93 and Chrome &gt;= 85 support AVIF</span>
<span class="hljs-keyword">if</span> (<span class="hljs-variable">$name</span> === <span class="hljs-string">'Firefox'</span> &amp;&amp; <span class="hljs-variable">$version</span> &gt;= <span class="hljs-number">93</span> || <span class="hljs-variable">$name</span> === <span class="hljs-string">'Chrome'</span> &amp;&amp; <span class="hljs-variable">$version</span> &gt;= <span class="hljs-number">85</span>) {
header(<span class="hljs-string">'Link: rel=preload; href=/document.designmode.avif; type=image/avif'</span>);
} <span class="hljs-keyword">else</span> {
header(<span class="hljs-string">'Link: rel=preload; href=/document.designmode.jpeg; type=image/jpeg'</span>);
}
</code></pre>

    <p>If you’re going to do something like this, I’d recommend setting up server-side analytics so you know if (when) your pushed image format ends up being different from the one the browser requests. If you want to get real fancy, you could automatically update your caniuse table based on those analytics results as well (e.g., when a new Safari version is released that supports AVIF, your system picks it up after the first few requests and starts pushing AVIF to all new requests where the User-Agent indicates that Safari version.)</p>

    <hr>

    <p>Ok that’s it. Thanks for reading!</p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
