<?php
if (!key_exists('q', $_GET) || $_GET['q'] === '') {
    header('Location: /');
    die();
}

$query = $_GET['q'];

$conn = pg_connect('user=blog');
$results = pg_query_params($conn, '
        select title, description, date, slug, content
        from posts, 
            to_tsvector(slug || \' \' || title || \' \' || description || \' \' || content || \' \') as textsearch,
            to_tsquery($1) as query
        where textsearch @@ query
        order by ts_rank_cd(textsearch, query) desc;',
    array($query)
);

require __DIR__ . '/.begin.php';
?>
    <style><?php require_once __DIR__ . '/index.css' ?></style>
<?php
while ($post = pg_fetch_array($results)) { ?>
    <a href="./<?php echo $post['slug'] ?>" class="card">
        <div class="card-header">
            <small>
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
