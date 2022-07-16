<?php

$title = 'What is an eTLD + 1?';
$date = '2022-07-16';
$description = "In short, an eTLD + 1 is the part of the web address that tells you who owns a website. What does that 
mean and how exactly can you find it? This post answers these questions.";

require_once __DIR__ . '/../.begin.php';

?>

<style>
    .invert-light {
        filter: invert(100%);
    }
    @media screen and (prefers-color-scheme: dark) {
        .invert-light {
            filter: none;
        }
    }
</style>

<h1>What is an eTLD + 1?</h1>
<p>In short, an eTLD + 1 is the part of the web address that tells you who owns a website. What does that mean and how
    exactly can you find it? This post answers these questions.
</p>
<h2>#0 what is a domain?</h2>
<p>The domain is the part of a website address after the protocol (<code>https://</code>) and before the next
    slash. In a URL like <code>https://jfhr.me/what-is-an-etld-+-1</code> , the domain is <code>jfhr.me</code> .
</p>
<h2>#1 what is a TLD?</h2>
<p>A domain consists of one or more parts separated by dots. The TLD is the last part. In the domain
    <code>jfhr.me</code> , the <code>me</code> is the TLD.
</p>
<h2>#2 what is an eTLD?</h2>
    <p>The eTLD consists of <b>the last n parts of a domain that are shared between multiple sites from different owners</b>.
    In <code>www.google.com</code> , the <code>com</code> is the TLD and also the eTLD - because there are many
    different pages with different owners ending in <code>com</code> , but all pages ending in <code>google.com</code>
    belong to google. In <code>www.google.co.uk</code> , the TLD is <code>uk</code> , but the eTLD is <code>co.uk</code>
    , because there are many different pages with different owners ending in <code>co.uk</code> .
</p>
<h2>#3 what is an eTLD + 1?</h2>
<p>The eTLD + 1 is the eTLD plus one more domain part. By definition, the eTLD + 1 and all pages below it belong to the
    same person or organization. For example, <code>google.com</code> is a eTLD + 1, because everything below it (like
    <code>www.google.com</code> or <code>drive.google.com</code> ) belong google.
</p>
<p>
    <picture>
        <source srcset="etld.avif" type="image/avif">
        <source srcset="etld.webp" type="image/webp">
        <img src="etld.png" width="605" height="268" alt="Diagram showing the domain www.google.co.uk, the part uk is marked as TLD, the part co.uk is marked as eTLD, and the part google.co.uk is marked as eTLD + 1" class="invert-light">
    </picture>
</p>
<p>
    <small>Schematic diagram of TLD, eTLD, and eTLD + 1.</small>
</p>
<h2>#4 why does it matter?</h2>
    <p>There is a list called the <b>public suffix list</b> which aims to list all eTLDs on the internet. Browser
    use it in different ways, but maybe the most important is to restrict cookies. You've probably heard of cookies,
    they are small pieces of information that websites can store in your browser. Every cookie is associated with a
    domain, and it can be accessed by that domain and all domains below it. When you visit <code>www.google.co.uk
    </code>, it can set a cookie for <code>google.co.uk</code> , and when you later visit <code>drive.google.co.uk
    </code> it can still read that cookie.
</p>
<p>But importantly, <code>www.google.co.uk</code> can't set a cookie for just <code>co.uk</code> ! Because that is an
    eTLD, so it doesn't have a single owner. If you set a cookie there, almost all British websites would be able to
    read it, which would be terrible for your security and privacy.
</p>
<p>You can find the public suffix list here: <a href="https://publicsuffix.org/">https://publicsuffix.org/</a> and under
    "Learn more" there's also more background.
</p>

<?php
require_once __DIR__ . '/../.end.php';
