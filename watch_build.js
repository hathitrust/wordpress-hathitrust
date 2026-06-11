//for esbuild watch mode
import * as esbuild from 'esbuild';

let ctx = await esbuild.context({
  entryPoints: [
    'src/js/scripts.js',
    'src/css/style.css',
    'src/css/home.css',
    'src/css/editor-style.css',
    'src/js/cookies.js',
    'src/js/highlight.js',
    'src/css/print-holdings-checker.css'
  ],
  bundle: false,
  minify: true,
  outdir: 'dist',
  outExtension: { '.js': '.min.js', '.css': '.min.css' },
  logLevel: 'info',
});

let holdingsCtx = await esbuild.context({
  entryPoints: ['src/js/print-holdings-checker/index.js'],
  bundle: true,
  minify: true,
  outfile: 'dist/js/print-holdings-checker.min.js',
  logLevel: 'info',
});

await ctx.watch();
await holdingsCtx.watch();

console.log('watching...');
