<?php

echo '<?xml version="1.0" encoding="UTF-8" ?>';

require_once __DIR__ . '/.get_posts.php';
$posts = get_posts();

function rfc822date($date) {
    return gmdate("D, d M Y H:i:s T", strtotime($date));
}

header('content-type: application/rss+xml');
?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>blog | jfhr</title>
        <link>https://jfhr.me</link>
        <language>en-us</language>
        <image>
            <url>https://jfhr.me/assets/favicon-196.png</url>
            <link>https://jfhr.me</link>
            <title>blog | jfhr</title>
        </image>
        <copyright>Released under CC-0</copyright>
        <managingEditor>me@jfhr.de (jfhr)</managingEditor>
        <webMaster>me@jfhr.de (jfhr)</webMaster>
        <lastBuildDate>Tue, 12 Apr 2022 22:00:00 GMT</lastBuildDate>
        <pubDate>Tue, 12 Apr 2022 22:00:00 GMT</pubDate>
        <ttl>1440</ttl>
        <docs>https://www.rssboard.org/rss-specification</docs>
        <atom:link href="https://jfhr.me/index.rss" rel="self" type="application/rss+xml" />

        <?php foreach ($posts as $post) { ?>
        <item>
            <title><?php echo htmlspecialchars($post['title']); ?></title>
            <description><?php echo htmlspecialchars($post['content']); ?></description>
            <author>me@jfhr.de (jfhr)</author>
            <link>https://jfhr.me/<?php echo $post['slug']; ?></link>
            <guid isPermaLink="true">https://jfhr.me/<?php echo $post['slug']; ?></guid>
            <pubDate><?php echo rfc822date($post['date']); ?></pubDate>
        </item>
        <?php } ?>
    </channel>
</rss>
