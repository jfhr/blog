<?php

require_once __DIR__ . '/.get_posts.php';
$posts = get_posts_v1();

$description = 'Hi, I write blog posts about software development and little else. If you enjoy this blog, feel free to say hello :)';

require __DIR__ . '/.begin.php';
?>

<style><?php require_once __DIR__ . '/index.css' ?></style>

<section class="blog-heading">
    <h1>jfhr's blog</h1>
    <p>
        Hi, I write blog posts about software development and little else.
        If you enjoy this blog, feel free to
        <a href="mailto:me@jfhr.de?subject=Hello!">say hello</a> :)
    </p>
</section>

<?php
foreach ($posts as $i => $post) {
?>
<a href="./<?php echo $post['slug'] ?>" class="card">
    <div class="card-header">
        <small>
            <?php if ($i === 0) { ?>
            Latest post:
            <?php } ?>
            <time datetime="<?php echo $post['date']; ?>">
                <?php echo $post['date']; ?>
            </time>
        </small>
    </div>
    <div class="card-body">
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['description']; ?></p>
    </div>
</a>
<?php } ?>

<?php
require __DIR__ . '/.end.php';
