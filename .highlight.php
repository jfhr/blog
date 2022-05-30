<?php

require_once __DIR__ . '/vendor/autoload.php';

function highlight(string $language, string $code): void
{
    $highlighter = new \Highlight\Highlighter();
    $result = $highlighter->highlight($language, $code);
    echo '<pre><code class="hljs language-' . $language . '">';
    echo $result->value;
    echo '</code></pre>';
}
