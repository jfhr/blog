<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Optimizing images with the CSS image-set() function';
$description = 'I previously blogged about optimizing images with the HTML &lt;picture&gt; tag. You can use the image-set() function to get equivalent behavior in CSS.';
$date = '2022-04-09';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>Optimizing images with the CSS image-set() function</h1>
    <p>I previously blogged about <a href="/optimizing-images-with-the-html-picture-tag">optimizing images with the HTML &lt;picture&gt; tag</a>. Tl;dr the <code>&lt;picture&gt;</code> tag lets you specify multiple sources for an image, and the browser will load the first one that it supports.</p>
    <p>Short example:</p>
    <?php highlight('html', '<div class="bg-image"></div>
<style>
.bg-image {
    background-image: url("./image.png");
    /* Vendor prefix for chromium browsers */
    background-image: -webkit-image-set(url("./image.avif") type("image/avif"), url("./image.webp") type("image/webp"));
    background-image: image-set(url("./image.avif") type("image/avif"), url("./image.webp") type("image/webp"));
}
</style>'); ?>
    <p>Supporting browsers will choose the first image format they support, and use it as the background-image.</p>
    <div class="bg-image invert">
        <style>
            .bg-image {
                background-image: url("https://jfhr.me/your-browser-supports.jpeg");
                background-image: -webkit-image-set(url("https://jfhr.me/your-browser-supports.avif") type("image/avif"), url("./your-browser-supports.webp") type("image/webp"));
                background-image: image-set(url("https://jfhr.me/your-browser-supports.avif") type("image/avif"), url("./your-browser-supports.webp") type("image/webp"));
                width: 400px;
                height: 100px;
            }
        </style>
    </div>
    <p class="text-secondary">You can inspect the image above to see the <code>image-set</code> function in action.</p>
    <p>Browser support for <code>image-set()</code> is <a href="https://caniuse.com/?search=image-set">relatively poor</a>, and Chromium browsers currently require the <code>-webkit-</code> prefix. To make sure your images work everywhere, you need a separate declaration, in this example a <code>background-image: url("...")</code> without an <code>image-set()</code>.</p>
    <p>But it's worth it for the browsers that do support it! At <a href="https://insiderpie.de">InsiderPie</a>, we managed to reduce the combined image size on a page with lots of images by more than 97% in Firefox, by using AVIF instead of PNG.<p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
