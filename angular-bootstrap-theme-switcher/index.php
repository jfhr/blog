<?php
header('link: '
    . 'rel="preload"; as="image"; type="image/avif" href="https://jfhr.me/your-browser-supports.avif",'
    . 'rel="preload"; as="image"; type="image/webp" href="https://jfhr.me/your-browser-supports.webp",'
    . 'rel="preload"; as="image"; type="image/jpeg" href="https://jfhr.me/your-browser-supports.png"'
);

$title = 'Light and dark themes with Angular, Bootstrap and SASS';
$description = "<p>Let's say you have an Angular single-page app and use Bootstrap for styling. You want to let your users choose between multiple themes (e.g. a light and dark theme). You also want the option to use custom SASS for each theme, as well as for all themes at once.</p>
<h3>The solution</h3>
<p>...</p>";
$date = '2021-05-21';

require_once __DIR__ . '/../.highlight.php';
require_once __DIR__ . '/../.begin.php';
?>

<article>
    <h1>Light and dark themes with Angular, Bootstrap and SASS</h1>
    <p><strong>Let's say</strong> you have an Angular single-page app and use Bootstrap for styling. You want to let your users choose between multiple themes (e.g. a light and dark theme). You also want the option to use custom SASS for each theme, as well as for all themes at once.</p>
    <h2>The solution</h2>
    <p><strong>If you just want the code</strong>, <a href="https://github.com/jfhr/ngb-theme-switcher-example">it's on github</a>. It's CC-0, so feel free to copy it into your project :)</p>
    <p>There's also a <a href="/angular-bootstrap-theme-switcher/demo/index.html">demo here</a></p>
    <h3>1. Install bootstrap</h3>
    <p>If you haven't included bootstrap yet, or if you've been using it via a CDN, install it with npm:</p>
    <?php highlight('bash', 'npm install bootstrap'); ?>
    <h3>2. Create your themes</h3>
    <p>Create a separate file for each theme you want to include. I'm using SASS here, but if you prefer SCSS, it's basically the same process. As a simple example, let's create two files in the <code>src</code> directory of our app, <code>light.sass</code> and <code>dark.sass</code>.</p>
    <p>The light theme simply imports bootstrap with no changes:</p>
    <?php highlight('scss', '@import \'~bootstrap/scss/bootstrap\''); ?>
    <p>The dark theme overrides bootstrap's default color variables:</p>
    <?php highlight('scss', '$body-bg:       #060606
$body-color:    #d6d6d6

@import \'~bootstrap/scss/bootstrap\''); ?>
        <p>You can create as many themes as you like, just make sure to always <code>@import</code> bootstrap at the end.</p>
        <p>If you don't fancy making your own themes, you can find free ones at <a href="https://bootswatch.com">bootswatch</a>. Simply download the <code>_variables.scss</code> file for each theme you want, give it a unique name and place it inside your app!</p>
        <h3>3. Configure Angular</h3>
        <p>We want Angular to turn each of our themes into a separate CSS file, so we can switch between them at runtime. Add the following to your <code>angular.json</code>:</p>
        <?php highlight('json', '{
    //...
    "projects": {
        "my-project": {
            "architect": {
                "build": {
                    "styles": [
                        "src/styles.sass",
                        {
                            "input": "src/light.sass",
                            "bundleName": "light",
                            "inject": true
                        },
                        {
                            "input": "src/dark.sass",
                            "bundleName": "dark",
                            "inject": false
                        }
                    ]
                }
            }
        }
    }
}'); ?>
    <p>For each theme, add a bundle to the <code>styles</code> array. This will tell angular to turn that SASS into a separate CSS file. The <code>"inject"</code> property should be set to <code>true</code> on your default theme (the one used for new visitors), and <code>false</code> on all others.</p>
    <h3>4. Implement a ThemeService</h3>
    <p>Let's create a service to change the theme at runtime:</p>
    <?php highlight('bash', 'ng generate service Theme'); ?>
    <p><em>theme.service.ts</em></p>
    <?php highlight('typescript', "import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ThemeService {

  public static default = 'light';

  public get current(): string {
    return localStorage.getItem('theme') ?? ThemeService.default;
  }

  public set current(value: string) {
    localStorage.setItem('theme', value);
    this.style.href = `/\${value}.css`;
  }

  private readonly style: HTMLLinkElement;

  constructor() {
    this.style = document.createElement('link');
    this.style.rel = 'stylesheet';
    document.head.appendChild(this.style);

    if (localStorage.getItem('theme') !== undefined) {
        this.style.href = `/\${this.current}.css`;
    }
  }
}"); ?>
        <p>This service lets us set the current theme, and then downloads the corresponding CSS file. The theme is saved to <code>localStorage</code>, so the next time the user opens the page, their selected theme will be applied automatically.</p>
        <p>If your app has a user login system, you could even store the selection in a database, so that it's synced across devices.</p>
        <p>If you're using Angular CDK, the <code>MediaMatcher</code> lets you check if the user has enabled a dark theme in their browser or operating system. You could then set your app to dark right away. However, not all browsers implement this feature, so it's a good idea to also let your users switch manually.</p>
        <h3>5. Add the theme switcher UI</h3>
        <p>Finally, we need some sort of UI that allows our users to select their favorite theme. In this case, since we only have two themes, a simple toggle button is enough. Let's generate a component for this:</p>
        <?php highlight('bash', 'ng generate component theme-switcher'); ?>
        <p><em>theme-switcher.component.ts</em></p>
        <?php highlight('typescript', "import { Component, OnInit } from '@angular/core';
import { ThemeService } from \"../theme.service\";

@Component({
  selector: 'app-theme-switcher',
  templateUrl: './theme-switcher.component.html',
  styleUrls: ['./theme-switcher.component.sass']
})
export class ThemeSwitcherComponent implements OnInit {

  constructor(private theme: ThemeService) { }

  ngOnInit(): void {
  }

  public switchTheme(): void {
    if (this.theme.current === 'light') {
        this.theme.current = 'dark';
    } else {
        this.theme.current = 'light';
    }
  }

}"); ?>
    <p><em>theme-switcher.component.html</em></p>
    <?php highlight('html', '<button class="btn btn-secondary" (click)="switchTheme()">Switch theme</button>'); ?>
    <p>We can now use this component anywhere on our page, for example on the homepage or in the navigation bar.</p>
    <h2>Example</h2>
    <p>This post shows only the essential steps. I've published a <a href="https://github.com/jfhr/ngb-theme-switcher-example">more complete example on GitHub</a>, which uses 4 different themes, and mixes SASS and SCSS.</p>
    <p>If something isn't working, let me know by <a href="https://github.com/jfhr/ngb-theme-switcher-example/issues/new">opening an issue there</a>!</p>
    <p>Have fun coding :)</p>
</article>

<?php
require_once __DIR__ . '/../.end.php';
