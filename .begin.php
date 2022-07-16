<?php
if (!isset($code)) {
    $code = true;
}

if ($code) {
    $link = 'link: '
        . 'rel="preload"; as="stylesheet"; type="text/css" href="https://jfhr.me/assets/a11y-light.css"; media="(prefers-color-scheme: light and prefers-contrast: more)",'
        . 'rel="preload"; as="stylesheet"; type="text/css" href="https://jfhr.me/assets/a11y-dark.css"; media="(prefers-color-scheme: dark and prefers-contrast: more)",'
        . 'rel="preload"; as="script"; type="application/javascript" href="https://jfhr.me/assets/highlight.min.js"';
    header($link);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#101012" media="(prefers-color-scheme: dark)">

    <style>
        @layer global {
            body {
                font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            }

            .container {
                box-sizing: border-box;
                width: 100%;
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            @media (min-width: 576px) {
                .container {
                    max-width: 540px
                }
            }
            @media (min-width: 768px) {
                .container {
                    max-width: 720px
                }
            }
            @media (min-width: 992px) {
                .container {
                    max-width: 960px
                }
            }
            @media (min-width: 1200px) {
                .container {
                    max-width: 1140px
                }
            }
            @media (min-width: 1400px) {
                .container {
                    max-width: 1320px
                }
            }
            header,
            footer {
                position: fixed;
                left: 0;
                right: 0;
                z-index: 1030;

                background-image: linear-gradient(white, #eee 50%, #e4e4e4);
            }

            header {
                top: 0;
                border-bottom: 1px solid #d5d5d5;
            }

            footer {
                bottom: 0;
                border-top: 1px solid #d5d5d5;
            }

            header > nav,
            footer > nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: nowrap;

                padding: .5rem .75rem;
            }

            header > nav > .logo {
                margin-right: .5rem;
            }

            header > nav > .search {
                flex-grow: 1;
                flex-shrink: 1;
                margin-right: .5rem;
            }

            header > nav > .search > input {
                width: 100%;
                padding: .375rem .75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #777;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            header > nav > .search > input::placeholder {
                color: #777;
                opacity: 1;
            }

            header > nav > .nav-link {
                padding: .5rem 1rem;
                color: #3399f3;
                transition: color 0.2s ease-in-out;
            }

            header > nav > .nav-link:focus,
            header > nav > .nav-link:hover {
                color: #297ac2;
            }

            main,
            footer > nav > a {
                color: #777;
            }

            main {
                margin-top: calc(56px + 1rem);
                margin-bottom: calc(42px + 2rem);
                padding-left: .75rem;
                padding-right: .75rem;
                line-height: 1.5;
            }

            main small {
                color: #666;
            }

            main h1,
            main h2,
            main h3,
            main h4,
            main h5,
            main h6 {
                margin-top: 0;
                margin-bottom: 0.5em;
                line-height: 1.2;
                font-weight: 500;
                color: black;
            }

            main h1 {
                font-size: 2.5rem;
            }

            main h2 {
                font-size: 2rem;
            }

            main h3 {
                font-size: 1.5rem;
            }

            main p,
            main pre {
                margin-top: 0;
                margin-bottom: 1em;
            }

            main img {
                max-width: calc(100vw - 24px);
                margin-bottom: 1rem;
            }

            main code {
                font-family: Courier, monospace;
                color: #df0088;
            }

            @media (prefers-contrast: more) {
                main,
                footer > nav > a {
                    color: #444;
                }
            }

            @media (prefers-color-scheme: dark) {
                body {
                    color-scheme: dark;
                    background-color: #101012;
                    color: white;
                }

                .invert {
                    filter: invert(100%);
                }

                header > nav > .logo {
                    filter: invert(80%);
                }

                header > nav > .search > input {
                    color: #eee;
                    background-color: #101012;
                    border: 1px solid #202024;
                }

                header,
                footer {
                    background-image: linear-gradient(to top, #101012, #18181b 50%, #202024);
                }

                header {
                    border-bottom: 1px solid #202024;
                }

                footer {
                    border-top: 1px solid #3b3b3b;
                }

                header > nav > .nav-link {
                    padding: .5rem 1rem;
                    transition: color 0.2s ease-in-out;
                }

                footer > nav > a {
                    color: #aaa;
                }

                a {
                    color: #36a1ff;
                }

                a:focus,
                a:hover {
                    color: #1c95ff;
                }

                main small {
                    color: #999;
                }

                main {
                    color: #bbb;
                }

                main code {
                    color: #ff7fcd;
                }

                main h1,
                main h2,
                main h3,
                main h4,
                main h5,
                main h6 {
                    color: white;
                }
            }

            <?php if (function_exists('highlight')) { ?>
            .hljs.language-bash::before {
                content: '$ ';
            }
            @media (prefers-color-scheme: light) {
                pre code.hljs {
                    background-color: #f0f0f0 !important;
                }
            }
            @media (prefers-contrast: more) {
                pre code.hljs {
                    border-radius: .25rem;
                }

                @media (prefers-color-scheme: light) {
                    pre code.hljs {
                        border: 1px solid #d5d5d5;
                        background-color: unset !important;
                    }
                }
            }
            <?php } ?>
        }
    </style>

    <?php if ($code) { ?>
        <link rel="stylesheet" href="https://jfhr.me/assets/a11y-dark.css" media="(prefers-color-scheme: dark)">
        <link rel="stylesheet" href="https://jfhr.me/assets/a11y-light.css" media="(prefers-color-scheme: light)">
    <?php } ?>

    <?php
    if (!isset($title)) {
        $title = 'blog';
    }
    ?>
    <title><?php echo $title; ?> | jfhr</title>
    <meta name="og:title" content="<?php echo $title; ?>">
    <?php if (isset($description)) { ?>
        <meta name="description" content="<?php echo htmlentities($description); ?>">
    <?php } ?>
    <?php if (isset($canonical)) { ?>
        <link rel="canonical" href="<?php echo $canonical; ?>">
    <?php } ?>
    <link rel="manifest" href="https://jfhr.me/manifest.json">
    <link rel="icon" type="image/png" sizes="196x196" href="https://jfhr.me/assets/favicon-196.png">

    <script>
        function initializeSearch() {
            const search = document.getElementById('search');
            window.addEventListener('keyup', function (ev) {
                if (ev.key === '/') {
                    search.focus();
                }
            });
        }
        function initializeSw() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.getRegistration().then(registration => {
                    if (registration) {
                        registration.unregister();
                    }
                });
            }
        }

        initializeSw();

        window.addEventListener('DOMContentLoaded', () => {
            initializeSearch();
        });
    </script>

    <link type="application/rss+xml" rel="alternate" href="https://jfhr.me/index.rss" title="RSS Feed"/>

    <link rel="apple-touch-icon" href="https://jfhr.me/assets/apple-icon-180.png">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta property="og:image" content="https://jfhr.me/assets/apple-icon-180.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="180">
    <meta property="og:image:height" content="180">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:image" content="https://jfhr.me/assets/apple-icon-180.png">

    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2048-2732.png"
          media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2732-2048.png"
          media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1668-2388.png"
          media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2388-1668.png"
          media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1536-2048.png"
          media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2048-1536.png"
          media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1668-2224.png"
          media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2224-1668.png"
          media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1620-2160.png"
          media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2160-1620.png"
          media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1284-2778.png"
          media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2778-1284.png"
          media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1170-2532.png"
          media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2532-1170.png"
          media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1125-2436.png"
          media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2436-1125.png"
          media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1242-2688.png"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2688-1242.png"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-828-1792.png"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1792-828.png"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1242-2208.png"
          media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-2208-1242.png"
          media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-750-1334.png"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1334-750.png"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-640-1136.png"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="https://jfhr.me/assets/apple-splash-1136-640.png"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">
</head>

<body>

<main class="container">
    <?php if (isset($date)) { ?>
    <small>
        <time><?php echo $date; ?></time>
    </small>
    <?php } ?>
