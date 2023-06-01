# HathiTrust WordPress theme

To work on this theme locally, use whatever LAMP stack you like, but I prefer the one-click install method of [Local by Flywheel](https://localwp.com/). Otherwise, you'll want to follow a how-to guide for your preferred php server/database combo (XAMPP? MAMP? WAMP?) that includes downloading the latest WP core, installing, and setting up a dummy database.

Locally, the theme is set up to use unminified CSS and JS files from the `/src` directory for simpler debugging, but you should run `npm run watch` for esbuild to watch your files and minify them into the `/dist` directory for preview/production. (If you are using Local instead of MAMP/XAMPP, the `local` environment variable is already set up for you. If not, will need to [add this line to your `wp-config.php` file](https://developer.wordpress.org/apis/wp-config-php/#wp-environment-type)-- in the WP core, not part of the theme-- in order to serve the unminified files locally. This may or may not be important to you!).

```php
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```
