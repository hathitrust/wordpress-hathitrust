//for esbuild watch mode
import * as esbuild from 'esbuild';

let ctx = await esbuild.context({
  entryPoints: [
    'src/js/scripts.js',
    'src/css/style.css',
    'src/css/home.css',
    'src/css/editor-style.css',
  ],
  bundle: false,
  minify: true,
  outdir: 'dist',
  outExtension: { '.js': '.min.js', '.css': '.min.css' },
  logLevel: 'info',
});

await ctx.watch();

console.log('watching...');
