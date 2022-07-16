<?php

$title = 'Strict Transport Security and preloading';
$date = '2022-07-15';
$code = false;

require_once __DIR__ . '/../.begin.php';

?>
    <h1>Strict Transport Security and Preloading</h1>
    <p>You've probably heard that HTTPS makes websites more secure. That's true, but HTTPS has some limitations, and
        Strict Transport Security and Preloading are ways you can overcome those limitations.
    </p>
    <h2>#0 what does HTTPS do?</h2>
    <p>HTTPS adds encryption to the connection between your computer and the computer you're connecting to. That means
        that anyone with the ability to listen in on your connection can't actually see any of the stuff you're
        transmitting. They can see <i>which website</i> you're connecting to though. For example, if you're googling
        something, they can see that you're connected to <code>www.google.com</code> , but they can't see the term you
        searched for.
    </p>
    <p>HTTPS also ensures that the domain you're visiting and the server sending the response belong together. In other
        words, it prevents a malicious server impersonating a domain that it doesn't really own. To achieve that, every
        HTTP server must present a public certificate for its domain, and browser make sure that certificate is valid.
        To get a valid certificate, you need a certificate authority, and those authorities generally make sure that you
        actually own the domain before giving you a certificate.
    </p>
    <h2>#1 why do you need HTTPS?</h2>
    <p>Multiple bad things could happen if you connect to a website with HTTP, without encryption. First, your internet
        provider could monitor evertything you do on that website. They could see which subpages you visit and if you
        enter anything into a form (like your name or password or a credit card number), they could see that too. They
        could also change what you see in your browser (for example by injecting ads that aren't part of the website
        itself).
    </p>
    <p>Your internet provider would probably collect and store that data (in many countries they would actually be
        required to). They would also be required to hand it over to the government when it asks for it.
    </p>
    <p>Anyone else who manages to get access to your connection could also do all those things and even worse. If you
        download a piece of software via an insecure connection, an attacker could inject their own malware into that
        download.
    </p>
    <p>HTTPS has some other advantages too: <a href="https://www.httpvshttps.com">secure websites are faster</a>, better
        for the environment and favored by search engines.
    </p>
    <h2>#2 the first connection is insecure</h2>
    <p>When you type an address like <code>www.google.com</code> in your browser address bar, it will likely first
        attempt to connect via HTTP. The google server will return a response that redirects to HTTPS. However, that
        first interaction is unencrypted, meaning that an attacker could intercept the response and change it so it
        redirects to an entirely different page. For example, a phishing page that <i>looks like</i> google, but when
        you enter your login credentials there, they are sent to the attackers computer.
    </p>
    <h2>#3 Strict-Transport-Security: making the first connection secure</h2>
    <p>Web servers can send an additional header called <code>Strict-Transport-Security</code> as part of their
        response. This header tells browsers that they should <i>always</i> connect to this domain via HTTPS, which
        would prevent the above attack. In its simplest form the header has only a single property:
    </p>
    <pre><code>Strict-Transport-Security: max-age=63115200</code></pre>
    <p><code>max-age</code> is the policy lifetime in seconds (here: two years).</p>
    <p>You can also add the <code>includeSubDomains</code> directive, which tells the browser that the policy applies to
        all subdomains below the current domain.
    </p>
    <h2>#4 the <i>first</i> first connection is still insecure</h2>
    <p>You may have already noticed this: <code>Strict-Transport-Security</code> is a response header, meaning that it's
        only sent once you connect to a server. That means that the very first connection your browser ever makes to a
        website might still be over an insecure connection and could be vulnerable to attack.
    </p>
    <h2>#5 HSTS preloading: making every connection secure</h2>
    <p>There is a file in every modern browser called the preload list. If a domain is on that list, the browser will
        <i>always</i> connect to it via HTTPS, even on the very first connection, and even if you explicitly type <code>http://</code>
        in your address bar. This is in fact the only way to be reasonably sure that nobody can intercept a connection
        to that website.
    </p>
    <p>If you want to get your website on the preload list, there are a few steps:</p>
    <ol>
        <li>Make sure that your site and all webdomains work with HTTPS, and that all users you care about can use HTTPS
            (that's probably the case, but just be sure).
        </li>
        <li>Serve a header like <code>Strict-Transport-Security: max-age=63115200; includeSubDomains; preload</code> .
            The <code>max-age</code> must be at least one year, but two years are recommended.
            <code>includeSubDomains</code> is mandatory, you can only preload <a
                    href="https://jfhr.me/what-is-an-etld-+-1">an entire eTLD + 1</a>.
        </li>
        <li>Go to <a href="https://hstspreload.org">https://hstspreload.org</a> and enter your domain.</li>
        <li>If the page is green, you should see a form allowing you to submit your page to the preload list. Confirm
            the questions and submit the form.
        </li>
        <li>Wait - until the next release of each browser.</li>
    </ol>
    <p>You can then re-check on <a href="https://hstspreload.org">https://hstspreload.org</a> and it should say that
        your domain is on the preload list. Congrats, from now on every connection will be secure!
    </p>
    <h2>#6 another problem: certificate warnings</h2>
    <p>There is another problem with HTTPS: I said in #0 that HTTPS prevents domain impersonation, because you need a valid certificate. Well, what happens if you simply present an invalid certificate? The browser will show a warning like this:
    </p>
    <p>
        <picture>
            <source srcset="index.avif" type="image/avif">
            <source srcset="index.webp" type="image/webp">
            <img src="index.jpeg" width="375" height="269" alt="Screenshot showing a red crossed out padlock icon, with a heading next to it that says: This Connection Is Not Private. Below if the following text: This website may be impersonating self-signed.badssl.com to steal your personal or information. You should go back to the previous page. Below are two links: A less prominent one labeled Show Details and a more prominent one labeled: Go Back" loading="lazy">
        </picture>
    </p>
    <p>The warning shown in Safari makes it pretty sure that there's a security risk. That's already a big improvement over what these warnings used to look like:
    </p>
    <p>
        <picture>
            <source srcset="GmailNameMismatchIE6.avif" type="image/avif">
            <source srcset="GmailNameMismatchIE6.webp" type="image/webp">
            <img src="GmailNameMismatchIE6.jpeg" width="389" height="419" alt="Screenshot showing a window titled Security Alert. Inside is the following text: Information you exchange with this site cannot be viewed or changed by others. However, there is a problem with the site's security certificate. A green checkmark: The security certificate is from a trusted certifying authority. A green checkmark: The security certificate date is valid. A yellow warning sign: The name on the security certificate is invalid or does not match the mame of the site. Do you want to proceed? Below are three similar-looking buttons labeled: Yes, No and View Certificate." loading="lazy">
        </picture>
    </p>
    <p>However, when you click on "Show Details", Safari still has an option to circumvent the warning:</p>
    <p>
        <picture>
            <source srcset="index2.avif" type="image/avif">
            <source srcset="index2.webp" type="image/webp">
            <img src="index2.jpeg" width="375" height="306" alt="Screenshot of the following text: Safari warns you when a website has a certificate that is not valid. This may happen if the website is misconfigured or an attacker has compromised your connection. To learn more, you can view the certificate. If you understand the risks involved, you can visit this website." loading="lazy">
        </picture>
    </p>
    <p>A skilled social engineer could probably get many internet users to click that button and connect to a dangerous
        site.
    </p>
    <p>Here's the good news: HSTS preloading solves that problem! When you connect to a site on the preload list, and
        the server returns an invalid certificate, the warning looks like this:
    </p>
    <p>
        <picture>
            <source srcset="index3.avif" type="image/avif">
            <source srcset="index3.webp" type="image/webp">
            <img src="index3.jpeg" width="375" height="137" alt="Screenshot of the following text: Safari cannot open the page because it could not establish a secure connection to the server. There are no buttons or links below the text." loading="lazy">
        </picture>
    </p>
    <p>There is no way to circumvent the warning! This is the case in Firefox, Chrome, and Safari.</p>
    <h2>#7 conclusion: use HSTS preloading!</h2>
    <p>HSTS preloading is the best way to keep your visitors reasonably safe from a long list of potential attacks. It's
        free if you get your HTTPS certificate from <a href="https://letsencrypt.org/">Let's Encrypt</a>, which I highly
        recommend.
    </p>
<?php
require_once __DIR__ . '/../.end.php';
