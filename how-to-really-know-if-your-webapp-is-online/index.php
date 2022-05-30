<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'How to really know if your webapp is online';
$description = "<p>If you search for \"check online JavaScript\", you'll quickly come across the navigator.onLine property. Unsurprisingly, it returns true if you're online, and false if you aren't. In addition, the window.ononline and window.onoffline events notify you whenever that value changes.</p>
<h3>False positives</h3>
<p>If it was quite this easy, I wouldn't be sitting here writing a blog post about it. In fact, if we look at the spec, we find the following...</p>";
$date = '2021-09-17';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>How to <i>really</i> know if your webapp is online</h1>
    <p>If you search for "check online JavaScript", you'll quickly come across the <code>navigator.onLine</code> property.
        Unsurprisingly, it returns <code>true</code> if you're online, and <code>false</code> if you aren't. In addition, the
        <code>window.ononline</code> and
        <code>window.onoffline</code> events notify you whenever that value changes.
    </p>
    <h2>False positives</h2>
    <p>If it was quite this easy, I wouldn't be sitting here writing a blog post about it. In fact, if we look at the spec,
        we find the following:
    <blockquote class="blockquote">
        The onLine attribute must return false if the user agent will not contact the network when
        the user follows links or when a script requests a remote page (or knows that such an attempt would fail), and
        must return true otherwise.</blockquote>
    </p>
    <p>In other words, <code>navigator.onLine</code> being true does not necessarily mean that there is a working internet connection.
        Most implementations seem to only be checking if there's a <i>connected network adapter</i>. There are a number of
        circumstances where that's the case, but the internet is still unreachable. For example:</p>
    <ul>
        <li>The user is only connected to an internal network</li>
        <li>The user is inside a virtual machine, and the virtual network adapter is connected, but the host system is
            offline</li>
        <li>The user uses a VPN which has installed a virtual network adapter that is always connected</li>
    </ul>
    <h2>Just try it</h2>
    <p>How do you <i>actually</i> know if there is a working internet connection? Well, there's really only one way. You
        have to try it out. Do a <i>fetch</i> request to an appropriate target and see whether or not you get a network
        error. A simple example is below:</p>

    <?php echo highlight('javascript', "async function isInternetConnectionWorking() {
    if (!navigator.onLine) {
        return false;
    }
    const headers = new Headers();
    headers.append('cache-control', 'no-cache');
    headers.append('pragma', 'no-cache');
    try {
        await fetch(window.location.origin, { method: 'HEAD', headers });
        return true;
    } catch (error) {
        if (error instanceof TypeError) {
            return false;
        }
        throw error;
    }
}
"); ?>
    <p>A few things to note:</p>
    <ul>
        <li>First, we check <code>navigator.onLine</code> - if it's false, we are <i>definitely</i> offline according to the
            spec. If
            it's true, we run our test.</li>
        <li>We set the <code>cache-control</code> and <code>pragma</code> headers to prevent the browser from sending a
            cached response.</li>
        <li>We request our own site's origin, that way there's no need to worry about cross-origin access rules.</li>
        <li>We make a <code>HEAD</code> request instead of <code>GET</code>. A <code>GET</code> request would download the
            response content,
            which is unnecessary in this case.</li>
        <li>If we get an error that's not a <code>TypeError</code>, we re-throw it. There are two possible reasons for that:
            <ul>
                <li>The arguments passed to fetch are illegal (should never happen with this code)</li>
                <li>The fetch was aborted (to prevent that, don't abort the fetch)</li>
            </ul>
        </li>
    </ul>
    <h2>Actually, don't even try</h2>
    <p>While the above code works, it has a subtle problem: Potentially every time the function
        <code>isInternetConnectionWorking()</code> is called, it sends a new, non-cached <code>HEAD</code> request.
        That might put an undue burden on the network.
    </p>
    <p>A typical web app already makes plenty of requests during normal use. We can monitor <i>those</i> to detect whether
        or not we're online. Only if no request has occurred recently, we send one like in the above example to check if
        we're still connected.</p>
    <p>The revised example below uses a service worker to intercept network requests and update the online status. It also adds a
        special route, <code>/is-online</code>, that we can fetch to get the current online status. Note that service workers only work
        in <a href="https://caniuse.com/mdn-api_serviceworker">modern browsers</a>, and only on secure pages (served via
        HTTPS).
        If you're still not using HTTPS, well, you should stop reading this blog and
        <a href="https://letsencrypt.org/getting-started/">get on it</a>.
    </p>

    <p><i>index.js</i></p>

    <?php echo highlight('javascript', "navigator.serviceWorker.register('/sw.js');
async function isInternetConnectionWorking() {
    if (!navigator.onLine) {
        return false;
    }
    const response = await fetch('/is-online');
    if (response.status === 200) {
        const onlineStatus = response.json();
        return onlineStatus.value;
    }
    return true;
}
"); ?>

    <p><i>sw.js</i></p>

    <?php echo highlight('javascript', "// Interval in ms before we re-check the connectivity - change to your liking
const ONLINE_TIMEOUT = 10000;
let onlineStatus = { value: true, timestamp: new Date().getTime() };

async function getFromCache(request) {
    // get from cache, if you have one...
    throw new TypeError();
}

async function tryGetFromNetwork(request) {
    const timestamp = new Date().getTime();
    try {
        const response = await fetch(request);
        onlineStatus = { value: true, timestamp };
        return response;
    } catch (error) {
        if (error instanceof TypeError) {
            onlineStatus = { value: false, timestamp };
        }
        throw error;
    }
}

async function getOnlineState() {
    const now = new Date().getTime();
    const headers = new Headers();
    headers.append('cache-control', 'no-store');

    // If the last online status is recent, return it
    if (now - onlineStatus.timestamp < ONLINE_TIMEOUT) {
        return new Response(
            JSON.stringify(onlineStatus),
            { status: 200, statusText: 'OK', headers }
        );
    }
    // Otherwise, attempt a real fetch to re-check the connection
    else {
        try {
            await fetch(location.origin, { method: 'HEAD', headers });
            onlineStatus = { value: true, timestamp: now };
        } catch (error) {
            if (error instanceof TypeError) {
                onlineStatus = { value: false, timestamp: now };
            } else {
                throw error;
            }
        }
    }
    // Recursive call, this time the new status will be returned
    return await getOnlineState();
}

self.addEventListener('fetch', event => {
    if (event.request.method === 'GET' && event.request.url === `\${location.origin}/is-online`) {
        event.respondWith(getOnlineState());
    }
    else {
        event.respondWith(
            tryGetFromNetwork(event.request)
                // If the fetch fails, get a response from cache if you have one
                // If not, just delete the next line
                .catch(() => getFromCache(event.request))
        );
    }
});
"); ?>

    <p>That's it! Now, every time your app makes a request, the service worker will note whether it succeeded or
        not. From your app, you can fetch <code>/is-online</code> to get the latest connection status. If it's older than
        <code>ONLINE_TIMEOUT</code> milliseconds, the service worker will re-check for you.</p>
    <hr>
    <p>
        <a href="https://twitter.com/intent/tweet?in_reply_to=1438835185118818309">Leave a comment on twitter!</a>
    </p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
