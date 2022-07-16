<?php

require_once __DIR__ . '/.get_posts.php';
$posts = get_posts_from_fs();

$conn = pg_connect('user=blog');
foreach ($posts as $post) {
    pg_query_params(
        'insert into posts (title, description, date, slug, content) values ($1, $2, $3, $4, $5) on conflict do nothing',
        array($post['title'], $post['description'], $post['date'], $post['slug'], $post['content']),
    );
}
