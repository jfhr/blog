</main>

<header>
    <nav class="container">
        <a href="https://jfhr.me/" class="logo" tabindex="0">
            <img src="https://jfhr.me/assets/favicon-196.png" width="32" alt="blog logo">
        </a>
        <form class="search" method="get" action="/search.php">
            <input class="form-control me-2" type="search" placeholder="/ search" title="Search" id="search" name="q"
               <?php if (key_exists('q', $_GET)) { echo 'value="' . htmlspecialchars($_GET['q']) . '"'; } ?>
            >
        </form>
        <a class="nav-link" href="https://jfhr.me/index.rss" title="rss feed" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rss" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1zm0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1z"/>
            </svg>
        </a>
        <a class="nav-link" referrerpolicy="no-referrer" href="https://github.com/jfhr" title="github" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
            </svg>
        </a>
        <a class="nav-link" referrerpolicy="no-referrer" href="https://jfhrdotme.tumblr.com" title="tumblr" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" x="0px" y="0px" viewBox="0 0 90.2 159.3" xml:space="preserve">
                <path d="M63.6,159.3c-24,0-41.8-12.3-41.8-41.8V70.3H0V44.7C24,38.5,34,17.9,35.1,0H60v40.6h29v29.7H60v41.1 c0,12.3,6.2,16.6,16.1,16.6h14.1v31.3H63.6z"/>
            </svg>
        </a>
    </nav>
</header>

<footer>
    <nav class="container">
        <a rel="license" href="/cc0" class="text-secondary">
            Released under CC-0
        </a>
        <a class="text-secondary" href="/privacy">Privacy policy</a>
    </nav>
</footer>

</body>


</html>
