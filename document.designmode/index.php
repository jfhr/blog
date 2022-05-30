<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'document.designMode';
$description = '<code>document.designMode = "on";</code>
<p>This single line of JavaScript makes an entire webpage editable. Try it out here...</p>';
$date = '2021-07-12';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<style>
    #btn-design {
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;

        cursor: pointer;
        color: #fff;
        background-color: #446e9b;

        background-image: linear-gradient(#6d94bf, #446e9b 50%, #3e648d);
        border: 1px solid #345578;
        text-shadow: -1px -1px 0 rgba(0,0,0,.1);
        padding: .375rem .75rem;
        border-radius: .25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    #btn-design:focus,
    #btn-design:hover {
        background-image: linear-gradient(#5f8ab9,#3e648d 50%,#385a7f);
        border: 1px solid #2e4b69;
        background-color: #3a5e84;
    }
    #btn-design.btn-danger {
        background-image: linear-gradient(#ff1d1b,#cd0200 50%,#b90200);
        background-color: #cd0200;
        border-color: #cd0200;
    }
    #btn-design.btn-danger:focus,
    #btn-design.btn-danger:hover {
        background-image: linear-gradient(#ff0906,#b90200 50%,#a40200);
        background-color: #ae0200;
        border-color: #a40200;
    }
</style>

<article>
    <h1>document.designMode</h1>
    <p>
    <?php highlight('javascript', 'document.designMode = "on";'); ?>
    </p>
    <p>
        This single line of JavaScript makes an entire webpage editable. Try it out by clicking the button below:
    </p>
    <p>
        <button id="btn-design">designMode on</button>
    </p>
    <p>
        Now just click anywhere and add some text. Or delete something if you're feeling a little destructive today. Go have some fun.
    </p>
    <p>
        You can also make text bold, italic, underlined, all that fun stuff.
        On iOS, you even get a nice UI when selecting any text:
    <div>
        <picture>
            <source srcset="/document.designmode.avif" type="image/avif">
            <source srcset="/document.designmode.jxl" type="image/jxl">
            <img src="/document.designmode.jpeg" alt="Screenshot on iOS with selected text, showing a popup with options to make text Bold, Italic, or Underlined" width="375" height="153" class="border">
        </picture>
    </div>
    On desktop, you can use <b>Ctrl+B</b> for bold, <b>Ctrl+I</b> for italic, and <b>Ctrl+U</b> for underlined.
    Only android users seem to be out of luck. There's no popup UI and no keyboard shortcuts either.
    </p>
    <h2>Why why why</h2>
    <p>
        While this is all fun to play around with, it doesn't seem particularly productive. So, why was this API added in the first place?
        Well, according to <a href="https://web.archive.org/web/20190706034138/https://gizmodo.com/how-internet-explorer-shaped-the-internet-5937354#:~:text=designMode" rel="noreferrer">this Gizmodo article</a>, it was added in Internet Explorer 4. That was in 1997! That's almost a quarter century ago!
        It was intended to simplify text editing for Hotmail users. I don't know if it succeeded and, unfortunately, I don't know any Hotmail users I could ask about it.
    </p>
    <p>
        As things go on the web, new APIs are added, but old ones are never deleted. And that's why <code lang="js">document.designMode</code> is still around after all this time. Let's see if it lasts another 25 years.
    </p>
    <hr>
    <p>
        <a href="https://twitter.com/intent/tweet?in_reply_to=1414654261510692864">Leave a comment on twitter!</a>
    </p>
</article>

<script>
    const btnDesign = document.getElementById('btn-design');
    btnDesign.addEventListener('click', () => {
        if (document.designMode === 'on') {
            document.designMode = 'off';
            btnDesign.innerText = 'designMode on';
            btnDesign.classList.remove('btn-danger');
            btnDesign.classList.add('btn-primary');
        } else {
            document.designMode = 'on';
            btnDesign.innerText = 'designMode off';
            btnDesign.classList.remove('btn-primary');
            btnDesign.classList.add('btn-danger');
        }
    });
</script>
<?php
require_once __DIR__ . '/../.end.php';
