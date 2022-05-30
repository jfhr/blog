<?php
if (!key_exists('q', $_GET) || $_GET['q'] === '') {
    header('Location: /');
    die();
}

$query = $_GET['q'];

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/.get_posts.php';

$posts = get_posts();
$fuse = new \Fuse\Fuse($posts, array(
    'keys' => array('title', 'description', 'content'),
));
$results = $fuse->search($query);

require __DIR__ . '/.begin.php';
?>
    <style><?php require_once __DIR__ . '/index.css' ?></style>
<?php
foreach ($results as $result) {
    $post = $result['item'];
    ?>
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
