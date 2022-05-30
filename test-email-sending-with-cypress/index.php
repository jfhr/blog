<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Test Email sending with cypress';
$description = 'At InsiderPie we use our own little email newsletter software. I wanted to write an automated test to make sure that newsletter sending works correctly. In the spirit of full e2e testing, that meant verifying that newsletters are actually sent out, and that the unsubscribe link at the bottom of every email works correctly. Turns out, that\'s not as easy as it sounds.';
$date = '2022-02-16';

require_once __DIR__ . '/../.begin.php';
?>
<article>
    <h1>Test Email sending with cypress</h1><p>Shameless plug: <a href="https://app.insiderpie.de/newsletter" target="_blank">you can subscribe to the InsiderPie newsletter (in German) here</a></p><p>I wanted to add an automated test to make sure the newsletter works correctly. In the spirit of full <abbr title="end to end">e2e</abbr> testing, that meant verifying that newsletters are actually sent out, and that the unsubscribe link at the bottom of every email works correctly. </p><p>To that end, I used the <a href="https://github.com/mscdex/node-imap" target="_blank">imap npm package</a>. If a package has 100,000+ downloads a week and the last commit is 5 years ago, that's a good sign that it's either feature-complete or abandoned. And, well, imap isn't abandonded seeing as they're still answering issues (shoutout to mscdex).</p><h2>Problem #1: figuring out IMAP</h2><p>When you subscribe to our newsletter, you immediately get an email asking you to confirm your subscription. This is standard practice to prevent sending newsletters to people who don't really want them. When you click the confirm link, you get another email congratulating you on your choice. That second email contains an unsubscribe link.</p><p>The e2e test consisted of the following steps:</p><ul><li>Visit the subscribe page and enter a test email</li><li>Wait for the confirmation email </li><li>Click the confirmation link</li><li>Wait for the second email</li><li>Click the unsubscribe link</li><li>Check that the unsubscription worked</li></ul><p>To keep the test efficient, I wanted a notification as soon as an email lands in the test inbox. imap (the library) has an overwhelming amount of methods and options, which are very well documented but not really understandable if you're someone who really has no clue how IMAP (the protocol) works. Long story short, you need to:</p><ul><li>connect to an IMAP server</li><li>in the connect callback, open your inbox</li><li>in the open callback, add an event listener to the <code>'mail'</code>  event</li><li>in the <code>'mail'</code>  handler, fetch the latest message</li><li>in the message callback, get the body</li><li>in the body callback, collect the data in chunks and stitch them together</li><li>in the open callback, subscribe to your inbox</li></ul><p>Here's the mostly complete code for your reading displeasure:</p><pre><code class="language-javascript hljs"><span class="hljs-keyword">const</span> <span class="hljs-title class_">Imap</span> = <span class="hljs-built_in">require</span>(<span class="hljs-string">'imap'</span>);
<span class="hljs-keyword">const</span> imap = <span class="hljs-keyword">new</span> <span class="hljs-title class_">Imap</span>({
  <span class="hljs-comment">// you can probably get these values from your email provider</span>
  user, password, host, port, tls,
});
<span class="hljs-comment">/**
* connects only if we aren't already connected
* <span class="hljs-doctag">@returns</span> {<span class="hljs-type">Promise</span>}
*/</span>
<span class="hljs-keyword">function</span> <span class="hljs-title function_">connectIMAP</span>(<span class="hljs-params"></span>) {
  <span class="hljs-keyword">if</span> (imap.<span class="hljs-property">state</span> !== <span class="hljs-string">'authenticated'</span>) {
    <span class="hljs-keyword">return</span> <span class="hljs-keyword">new</span> <span class="hljs-title class_">Promise</span>(<span class="hljs-function">(<span class="hljs-params">resolve, reject</span>) =&gt;</span> {
      imap.<span class="hljs-title function_">once</span>(<span class="hljs-string">'ready'</span>, <span class="hljs-function">() =&gt;</span> <span class="hljs-title function_">resolve</span>());
      imap.<span class="hljs-title function_">once</span>(<span class="hljs-string">'error'</span>, <span class="hljs-function"><span class="hljs-params">err</span> =&gt;</span> <span class="hljs-title function_">reject</span>(err));
      imap.<span class="hljs-title function_">connect</span>();
    });
  }
  <span class="hljs-keyword">return</span> <span class="hljs-title class_">Promise</span>.<span class="hljs-title function_">resolve</span>();
}
<span class="hljs-comment">/**
* waits for a new email and returns its entire content as a string
* <span class="hljs-doctag">@returns</span> {<span class="hljs-type">Promise</span>}
*/</span>
<span class="hljs-keyword">function</span> <span class="hljs-title function_">getEmail</span>(<span class="hljs-params"></span>) {
  <span class="hljs-keyword">return</span> <span class="hljs-keyword">new</span> <span class="hljs-title class_">Promise</span>(<span class="hljs-function">(<span class="hljs-params">resolve, reject</span>) =&gt;</span> {
    imap.<span class="hljs-title function_">openBox</span>(<span class="hljs-string">'INBOX'</span>, <span class="hljs-literal">true</span>, <span class="hljs-function">(<span class="hljs-params">err, box</span>) =&gt;</span> {
      <span class="hljs-keyword">if</span> (err) {
        <span class="hljs-title function_">reject</span>(err);
      }
      imap.<span class="hljs-title function_">once</span>(<span class="hljs-string">'mail'</span>, <span class="hljs-function">() =&gt;</span> {
        <span class="hljs-keyword">const</span> fetch = imap.<span class="hljs-property">seq</span>.<span class="hljs-title function_">fetch</span>(box.<span class="hljs-property">messages</span>.<span class="hljs-property">total</span> + <span class="hljs-string">':*'</span>, { <span class="hljs-attr">bodies</span>: <span class="hljs-string">''</span> });
        fetch.<span class="hljs-title function_">on</span>(<span class="hljs-string">'message'</span>, <span class="hljs-function">(<span class="hljs-params">msg, seqno</span>) =&gt;</span> {
          msg.<span class="hljs-title function_">on</span>(<span class="hljs-string">'body'</span>, <span class="hljs-function">(<span class="hljs-params">stream, info</span>) =&gt;</span> {
            <span class="hljs-keyword">let</span> content = <span class="hljs-string">''</span>;
            stream.<span class="hljs-title function_">on</span>(<span class="hljs-string">'data'</span>, <span class="hljs-function"><span class="hljs-params">chunk</span> =&gt;</span> {
              content += chunk.<span class="hljs-title function_">toString</span>(<span class="hljs-string">'utf-8'</span>);
            });
            stream.<span class="hljs-title function_">once</span>(<span class="hljs-string">'end'</span>, <span class="hljs-function">() =&gt;</span> {
              <span class="hljs-title function_">resolve</span>(content);
            });
          });
        });
      });
      imap.<span class="hljs-title function_">subscribeBox</span>(<span class="hljs-string">'INBOX'</span>, <span class="hljs-function"><span class="hljs-params">err</span> =&gt;</span> {
        <span class="hljs-keyword">if</span> (err) {
          <span class="hljs-title function_">reject</span>(err);
        }
      });
    });
  });
}
<span class="hljs-comment">// here's your email:</span>
<span class="hljs-title function_">connectIMAP</span>().<span class="hljs-title function_">then</span>(<span class="hljs-function">() =&gt;</span> <span class="hljs-title function_">getEmail</span>())</code></pre><h2>Problem #2: Invalid Version</h2><p>This is what I got running that first test:</p><pre><code class="language-text hljs language-plaintext">The following error originated from your test code, not from Cypress.
  &gt; Invalid Version:
When Cypress detects uncaught errors originating from your test code it will automatically fail the current test.
Cypress could not associate this error to any specific test.
We dynamically generated a new test to display this failure.</code></pre><p>We all love a helpful error message.</p><p>After spending <i>way too much time</i> researching, I found out that this issue means "you're trying to run node.js code in the browser, dummy.". Which is because cypress runs its tests entirely in the browser, unlike traditional selenium-based test frameworks.</p><p>To use node.js apis in cypress, you need to create a plugin in the aptly named plugins.js file, and call it from your test code with <code>cy.task()</code> . Here's what that plugin looks like in its simplest form:</p><pre><code class="language-javascript hljs"><span class="hljs-comment">/**
* <span class="hljs-doctag">@type</span> {<span class="hljs-type">Cypress.PluginConfig</span>}
*/</span>
<span class="hljs-variable language_">module</span>.<span class="hljs-property">exports</span> = <span class="hljs-function">(<span class="hljs-params">on, config</span>) =&gt;</span> {
  <span class="hljs-title function_">on</span>(<span class="hljs-string">'task'</span>, {
    <span class="hljs-keyword">async</span> <span class="hljs-string">"mail:receive"</span>() {
      <span class="hljs-keyword">await</span> <span class="hljs-title function_">connectIMAP</span>();
      <span class="hljs-keyword">return</span> <span class="hljs-keyword">await</span> <span class="hljs-title function_">getLatestEmail</span>();
    },
  });
  <span class="hljs-keyword">return</span> config;
};</code></pre><p>It doesn't get better in the actual test code:</p><pre><code class="language-javascript hljs"><span class="hljs-title function_">it</span>(<span class="hljs-string">'can subscribe to the newsletter'</span>, <span class="hljs-function">() =&gt;</span> {
  cy.<span class="hljs-title function_">visit</span>(<span class="hljs-string">'http://localhost:54321/newsletter'</span>);
  <span class="hljs-comment">// enter fancy test email and click 'subscribe' here </span>
  <span class="hljs-comment">// you probably need a higher timeout than the default 60,000 ms</span>
  cy.<span class="hljs-title function_">task</span>(<span class="hljs-string">'mail:receive'</span>, <span class="hljs-literal">null</span>, {<span class="hljs-attr">timeout</span>: <span class="hljs-number">240_000</span>})
    .<span class="hljs-title function_">then</span>(<span class="hljs-function"><span class="hljs-params">email</span> =&gt;</span> {
      <span class="hljs-comment">// check that email is ok and click confirm link</span>
      <span class="hljs-comment">// wait for second email</span>
      <span class="hljs-keyword">return</span> cy.<span class="hljs-title function_">task</span>(<span class="hljs-string">'mail:receive'</span>, <span class="hljs-literal">null</span>, {<span class="hljs-attr">timeout</span>: <span class="hljs-number">240_000</span>});
    })
    .<span class="hljs-title function_">then</span>(<span class="hljs-function"><span class="hljs-params">secondEmail</span> =&gt;</span> {
      <span class="hljs-comment">// check that second email is ok and click unsubscribe link</span>
    });
});</code></pre><p>You can't use <code>await</code>  in the test code because, well, <a href="https://github.com/cypress-io/cypress/issues/1417" target="_blank">you can't have everything in life</a>. </p><h2>Problem #3: Quoted-printable</h2><p>At this point, it was like 1 am and I was really counting on that test working. And it did! If by "work", you mean, "produced a new fun error". While I was able to received emails, the parsing still failed, because the email content looked like this:</p><pre><code class="hljs language-text"><span class="hljs-comment">// excerpt:</span>
Viele Gr=C3=BC=C3=<span class="hljs-number">9F</span>e,</code></pre><p>This is supposed to say "Viele Grüße" which is German for "Best Regards", but all the Umlauts were messed up. At first sight, this seems like an encoding issue, but I double-checked and the Email was sent as UTF-8 and I read it as UTF-8.</p><p>Well, turns out there are encodings on top of encodings. We live in a wonderful world.</p><p>This email used quoted-printable encoding, which is a way to convert utf-8 text into something that can be transmitted over a system that isn't 8-bit clean. Tl;dr, if you send a byte with the highest bit set, and it comes out the other end with the highest bit <i>unset</i>, then that system isn't 8-bit-clean. The reason such systems exist is because that's not an issue if you only use ASCII characters, and historically a lot of apps only used ASCII characters.</p><p>That aside, I now needed a way to decode that quoted-printable into actual utf-8 text. Fortunately, <a href="https://github.com/mathiasbynens/quoted-printable" target="_blank">there's a library for that</a>. Another one where the last commit was five years ago!</p><p>That library returns a byte stream, which needs to be utf-8 decoded again:</p><pre><code class="hljs language-javascript"><span class="hljs-keyword">const</span> quotedPrintable = <span class="hljs-built_in">require</span>(<span class="hljs-string">'quoted-printable'</span>);
<span class="hljs-keyword">const</span> utf8 = <span class="hljs-built_in">require</span>(<span class="hljs-string">'utf8'</span>);
<span class="hljs-comment">// ...</span>
utf8.<span class="hljs-title function_">decode</span>(quotedPrintable.<span class="hljs-title function_">decode</span>(content));</code></pre><p>With that, the test worked!</p><h2>Final thoughts</h2><p>In my setup, it takes on average ~100 seconds for the email to arrive. I'd imagine that different email providers could be faster (or slower) than that. Either way, testing mail <i>will</i> take more time than your usual "click around on a website" e2e tests. If you're in an environment with very frequent code changes, you might want to limit when you run those specific tests.</p><p>Hope this post helped you, or at least was interesting. I'm going to bed now. love you all. gn</p>        </article>

<?php
require_once __DIR__ . '/../.end.php';
