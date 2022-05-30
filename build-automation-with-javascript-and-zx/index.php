<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Build automation with JavaScript and zx';
$description = "zx is an open-source tool by google for creating server-side scripts with JavaScript. In this post I'll talk a bit about what it does, and how and why I use it in several projects to automate builds.";
$date = '2021-11-13';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>Build automation with JavaScript and zx</h1><p><a href="https://github.com/google/zx">zx</a> is an open-source tool by google for creating server-side scripts with JavaScript. In this post I'll talk a bit about what it does, and how and why I use it in several projects to automate builds.</p><h2>Why JavaScript?</h2><p>JS may not be the <a href="https://insights.stackoverflow.com/survey/2021#most-loved-dreaded-and-wanted-language-love-dread">most popular programming language</a>, but it is <a href="https://insights.stackoverflow.com/survey/2021#most-popular-technologies-language">the most used</a>. And if you're building a web-app, you're probably using JS anyway — might as well write your build scripts in the same language.</p><p>Plus, JS is cross-platform. I develop web apps on macOS and Windows, and use Linux for continuous integration. My zx scripts work everywhere.</p><h2>How-To</h2><p>To get started, create a JavaScript file with a .mjs extension. .mjs stands for modular JavaScript — using this extension lets you use import instead of require. (If your package.json contains "type": "module", you could also use the .js extension. Though personally, I always use .mjs to keep things simple.)</p><p>The first line of a zx script is:<?php highlight('bash', '#!/usr/bin/env zx'); ?></p><p>This tells your environment to run the script with zx, although you don't really need it if you call zx explicitly. More importantly, it tells other developers that they're looking at a zx script. Someone who's never used the tool before might <a href="https://duckduckgo.com/?q=%23!%2Fusr%2Fbin%2Fenv+zx">search for this line</a> and find the zx github repo among the first results.</p><p>After that, just write some JavaScript. All the good stuff works:<?php echo highlight('javascript', "import { promisify } from 'util' // Import statements!
import { randomInt } from 'crypto'
const number = await promisify(randomInt)(0, 10) // Top-level await!!
console.log(number)"); ?></p><p>zx imports some libraries for you:<?php echo highlight('javascript', "await fs.ensureDir('temp')  // fs-extra (https://www.npmjs.com/package/fs-extra)
await console.log(chalk.green('directory temp created'))  // chalk (https://www.npmjs.com/package/chalk)
const res = await fetch('https://jfhr.me')  // node-fetch (https://www.npmjs.com/package/node-fetch)</code></pre></p><p>But most importantly, it's super easy to run command line programs:<pre><code>await $`npm install`
await $`npm run test`"); ?></p><p><code>$</code> is a shortcut for <code>child_process.spawn()</code>. It returns a promise that resolves when the process completes. If you want to run a process in background, simply don't await it:<?php echo highlight('javascript', "// run the server in the background
const server = $`npm run server`
// run the test script
await $`npm run test`
// send a terminate signal to the server process...
server.child.kill('SIGINT')
// ... and wait for it to shut down
await server"); ?></p><p>If your process ends with a non-zero exit code, zx will throw an error by default. But you can suppress it using <code>nothrow</code>:<?php echo highlight('javascript', "nothrow($`touch temp/file1.txt`)"); ?></p><p>This is just a teaser - you can learn more in the official <a href="https://github.com/google/zx#readme">zx README</a>.</p><p>If you want to use zx for build automation, I recommend installing it as a <code>devDependency</code> and adding the scripts to your package.json:<?php echo highlight('bash', "npm install -D zx"); ?></code></pre></p><p><i>package.json</i></p><p><?php echo highlight('javascript', '{
  "scripts": {
    "build": "zx build.mjs"
  }
  // ...
}'); ?></p><p>That way, anyone using your package can simply run <?php echo highlight('bash', "npm install
npm run build"); ?></p><p>without needing to know about zx.</p><h2>What for?</h2><p>I've used zx scripts in several projects to automate such stuff as:</p><ul><li>Installing and building dependencies where no pre-build package was available</li><li>Starting a test server, running cypress tests, and shutting the server down</li><li>Running multiple rollup and webpack builds, only some of which can run simultaneously</li></ul><p>Don't litter your <code>package.json</code> scripts with long lines of chained console commands. Use zx.</p>        </article>

<?php
require_once __DIR__ . '/../.end.php';
