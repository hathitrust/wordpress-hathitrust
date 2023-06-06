# HathiTrust WordPress theme

## develop locally

To work on this theme locally, use whatever LAMP stack you like, but I prefer the one-click install method of [Local by Flywheel](https://localwp.com/). Otherwise, you'll want to follow a how-to guide for your preferred php server/database combo (XAMPP? MAMP? WAMP?) that includes downloading the latest WP core, installing, and setting up a dummy database.

Locally, the theme is set up to use unminified CSS and JS files from the `/src` directory for simpler debugging, but you should run `npm run watch` for esbuild to watch your files and minify them into the `/dist` directory for preview/production. (If you are using Local instead of MAMP/XAMPP, the `local` environment variable is already set up for you. If not, will need to [add this line to your `wp-config.php` file](https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type)-- in the WP core, not part of the theme-- in order to serve the unminified files locally. This may or may not be important to you!).

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```

## deploy to server
1. Push your changes up to the repo (origin/main or PR dance).
1. For preview: On dev-3, the preview site is at `preview.www`. To update the theme, navigate to `preview.www/wp-content/themes/wordpress-hathitrust` and pull down the latest from github. 

## scripts and styles

Wordpress has a "fun" way of adding script and style tags to the site. If you need to add a one-line script or style tag, that's pretty easy to do following the many examples in `functions.php` within the `pg_enqueue_site_files()` function. (To deciper the variables being passed to the style and script functions, see [wp_enqueue_script() docs](https://developer.wordpress.org/reference/functions/wp_enqueue_script/)). For something a little longer (like our several-line matomo script), you'll want to add a separate file to the `/js/` directory and link to it from `functions.php`. You might notice that some of our scripts are loaded based on environment or page location (`if (is_front_page())` or ` if ('local' === wp_get_environment_type())`). If you want to load a script/style on a specific page or set of pages, Wordpress probably has a [conditional tag](https://codex.wordpress.org/Conditional_Tags) for it.

## firebird components

### header

`/inc/client-header.php`

### footer

`/inc/client-footer.php`

### feedback form

Front-end/template piece: `/inc/block-feedback_form.php`
Back-end/ACF registration: `/acf-json/group_63f526260d6ad.json`

