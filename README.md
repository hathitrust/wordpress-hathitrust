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

## custom wordpress pages

Generally, custom pages include a template file or template piece that is linked to a specific wordpress content page or pages. The piece that connects the content page to the template file is the page `post_name`, which is also the URL slug of the page. This `post_name`/slug needs to match the trailing name of the template file after `page-` in order to render.

If you would like a quick 10-minute screencast about custom pages and template files, here ya go: [Caryl creates the search widgets custom template and WP page](https://www.loom.com/share/ca81472dc14e4597adfa6f7feb482ec0)

### Hathifiles

Template file: `page-hathifiles.php` is more-or-less and copy/paste job of index.php (includes functions to grab header/footer/breadcrumbs/content) with additional markup for the file listing table and subsequent function that adds the files as rows to the table. You can find and edit the `file_list()` function at the bottom of `functions.php`.

Wordpress content: The general page content (including page title and URL slug) can be updated on the Hathifiles edit page screen. From the WP dashboard, select **Pages** from the sidebar. Locate the page named "Hathifiles" and click the blue title link or hover and select "Edit" from under the title.

### Search widgets

Template file: `page-widgets.php` has 5 search widget boxes under the regular content box. As of June 2023, these widgets use the files from the current prod site. I assume the files will be moved/served from wordpress but the paths in the widgets will remain the same?

### Ingest reports

Template file: `page-ingest-reports.php` at the moment is blank page with an empty table. The `file_list()` function needs to be updated with the path to the files and the output for the link path.

## updates and upgrades

To update/upgrade plugins and WP core, use the `wp cli` tool. It's installed under `carylw.www`. I was too nervous to add it to `/usr/bin` or wherever, so you'll have to use the full php commmand. From the directory where the core Wordpress files are installed, run: 

```
php /htapps/carylw.www/wp-cli.phar [command] <options>
```

Full list of commands: [wp-cli commmands](https://developer.wordpress.org/cli/commands/)

### install plugin

[wp plugin <command>](https://developer.wordpress.org/cli/commands/plugin/)

You'll need to search for the name of the plugin first, e.g.: `php /htapps/carylw.www/wp-cli.phar plugin search "safe redirect"`

Take the slug of the plugin from that list and run install with the activate option: `php /htapps/carylw.www/wp-cli.phar plugin install --activate safe-redirect-manager`

### update plugin

I've disabled auto-updates for plugins, so this needs to be done manually.

To get a list of the installed plugins and their update status/version number: `php /htapps/carylw.www/wp-cli.phar plugin list`

There are generally two schools of thought when it comes to updating plugins: 

1. do them all at once and let the chips fall where they may
2. update them one at a time and make sure your site didn't break

We don't have very many plugins installed so maybe it doesn't really matter (and you can always downgrade a plugin), but upgrade all at once at your own risk.

Commands:
- `plugin update --all`
- `plugin update --all --minor`
- `plugin update safe-redirect-manager`

### upgrade WP core

[wp core update](https://developer.wordpress.org/cli/commands/core/update/)

`php /htapps/carylw.www/wp-cli.phar core update` handles the downloading and installation of the latest WP version for you, but there are options for updating/downgrading to a specific version if that's necessary.