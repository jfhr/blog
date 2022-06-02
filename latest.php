<?php

require_once __DIR__ . '/.get_posts.php';

$posts = get_posts();
$slug = $posts[0]['slug'];
header('location: https://jfhr.me/' . $slug);
