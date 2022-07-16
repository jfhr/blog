<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Privacy Policy';
$date = '2022-04-09';
$code = false;

require_once __DIR__ . '/../.begin.php';

?>

<article>
    <h1>Privacy policy</h1>
    <h2>Definitions</h2>
    <p>"The website" refers to this website and all content provided on it. Note that the website may contain links to other
        websites. This privacy policy does not apply to those websites, and they might have their own policies.</p>
    <h2>Types of Information I collect</h2>
    <p>When you visit the website, technical details such as your IP address and user agent string are collected. This data is only kept for legitimate interests, such as diagnosing technical issues, and is deleted after seven days. It is not shared with anyone else.</p>
    <h2>Changes to this privacy policy</h2>
    <p>This policy might change from time to time. In that case, a notice will be posted on the homepage
        (<a href="https://jfhr.me">https://jfhr.me</a>). The current version will always be posted at
        <a href="https://jfhr.me/privacy">https://jfhr.me/privacy</a>. It is recommended that you revisit this policy regularly.</p>
    <h2>Contact</h2>
    <p>If you have any questions regarding this policy, please write to <a href="mailto:me@jfhr.de">me@jfhr.de</a>.</p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
