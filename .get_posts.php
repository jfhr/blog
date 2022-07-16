<?php

function get_posts_from_fs()
{
    $posts = array();
    ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);

    foreach (scandir('.') as $entry) {
        if (str_starts_with($entry, '.')) {
            continue;
        }
        if (is_dir($entry) && file_exists($entry . '/index.php')) {
            require $entry . '/index.php';
            $content = ob_get_contents();
            ob_clean();
            if (isset($title) && isset($description) && isset($date) && $content !== false) {
                $posts[] = array(
                    'title' => $title,
                    'description' => $description,
                    'date' => $date,
                    'slug' => $entry,
                    'content' => $content,
                );
            }
            unset($title, $description, $date, $content);
        }
    }

    ob_end_clean();

    usort($posts, function ($a, $b) {
        if ($a['date'] < $b['date']) {
            return 1;
        } else if ($a['date'] > $b['date']) {
            return -1;
        }
        return 0;
    });

    return $posts;
}

function get_posts() {
    $conn = pg_connect('user=blog');
    $result = pg_query($conn, 'select title, description, date, slug, content from posts order by date desc');
    $posts = array();
    while ($post = pg_fetch_array($result)) {
        array_push($posts, $post);
    }
    return $posts;
}
