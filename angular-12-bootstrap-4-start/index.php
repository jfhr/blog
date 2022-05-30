<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Start an app with Angular 12 and Bootstrap 4';
$description = 'Learn how to quickly create a web-app with Angular 12 and Bootstrap 4.';
$date = '2021-05-30';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';

?>

<article>
    <h1>Start an app with Angular 12 and Bootstrap 4</h1>
    <p>Before you start, there's also a <a href="/angular-12-bootstrap-5-start">guide for bootstrap 5 here</a>.</p>
    <p>Angular and Bootstrap are a great combination for building good-looking, interactive web-apps. This guide describes how I go about starting a new project:</p>
    <h2>1. Create an angular project</h2>
    <p>This step is simple, just run:</p>
    <?php highlight('bash', 'ng new ng12b4-example'); ?>
    <p>Replace <code>ng12b4-example</code> with the name of your project.</p>
    <p>The Angular CLI will ask which stylesheet format you would like to use - select SASS, that way we can overwrite bootstrap variables (see step 4). You could also use SCSS if you're into that.</p>
    <p>Finally,</p>
    <?php highlight('bash', 'cd ng12b4-example'); ?>
    <h2>2. Install bootstrap</h2>
    <p>For bootstrap version 4, run </p>
    <?php highlight('bash', 'npm install bootstrap@4.6.0'); ?>
    <h2>3. Include bootstrap styles</h2>
    <p>Add the following to <code>src/styles.sass</code>:</p>
    <?php highlight('scss', '@import \'~bootstrap/scss/bootstrap\''); ?>
    <p>This will add the bootstrap styles to our app.</p>
    <h2>4. (Optional) customize bootstrap variables</h2>
    <p>We can override bootstrap variables to make our app more unique. </p>
    <p>For example, default bootstrap uses rounded corners. If you're more into sharp edges, simply set the corresponding variable in <code>styles.sass</code>:</p>
    <?php highlight('scss', '// Variable overrides must come before the import
$border-radius: 0
@import \'~bootstrap/scss/bootstrap\''); ?>
    <h2>5. (Optional) install a library for interactive elements</h2>
    <p>If you only need the bootstrap styles, you can stop reading here. But if you want interactive elements (modals, alerts, etc.), you'll need one of two libraries: <code>ngx-bootstrap</code> by Valor software, or the community project <code>ng-bootstrap</code>. Both are released under the MIT License and, in my experience, both work well and have good documentation. I'll be using <code>ng-bootstrap</code> here:</p>
    <?php highlight('bash', 'ng add @ng-bootstrap/ng-bootstrap'); ?>
    <p>Note that this command might change your <code>styles.sass</code> by importing bootstrap again, which is well-meaning but redundant in this case. If that happens, just remove the second import.</p>
    <p>You'll also notice that <code>app.module.ts</code> has been changed and is now importing the <code>NgbModule</code>. Great!</p>
    <p>Consult the <a href="https://ng-bootstrap.github.io/#/home">ng-bootstrap docs</a> to find out how to use your new library.</p>
    <hr />
    <p>That's it! You can find the example code <a href="https://github.com/jfhr/ng12b4-example">on my github</a>.</p>
    <p>Remember that there's a separate <a href="/angular-12-bootstrap-5-start">guide for bootstrap 5 here</a>.</p>
    <p>You might also be interested in <a href="/angular-bootstrap-theme-switcher">how to add a custom theme switcher to your app</a>.</p>    </article>
</article>

<?php
require_once __DIR__ . '/../.end.php';
