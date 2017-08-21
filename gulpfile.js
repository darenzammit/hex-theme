/**
 * Gulp Packages
 */

// Config
const config = require('./assets/config.json');

// General
const argv = require('minimist')(process.argv.slice(2));
const browserSync = require('browser-sync');
const del = require('del');
const flatten = require('gulp-flatten');
const fs = require('fs');
const gulp = require('gulp');
const gulpif = require('gulp-if');
const lazypipe = require('lazypipe');
const plumber = require('gulp-plumber');
const reload = browserSync.reload;
const rename = require('gulp-rename');
const tap = require('gulp-tap');
const watch = require('gulp-watch');
const notify = require('gulp-notify');
const gutil = require('gulp-util');

// Scripts
const jshint = require('gulp-jshint');
const stylish = require('jshint-stylish');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

// Styles
const sass = require('gulp-sass');
const cssnano = require('gulp-cssnano');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');

// SVGs
const svgmin = require('gulp-svgmin');
const svgstore = require('gulp-svgstore');

// CLI options
const enabled = {
    cssmin: argv.production,
    jsmin: argv.production,
    maps: !argv.production
};

/**
 * Handle errors and alert the user.
 */
function handleErrors() {
    const args = Array.prototype.slice.call(arguments);

    notify.onError({
        'title': 'Task Failed [<%= error.message %>',
        'message': 'See console.',
        'sound': 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
    }).apply(this, args);

    gutil.beep(); // Beep 'sosumi' again.

    // Prevent the 'watch' task from stopping.
    this.emit('end');
}

/**
 * Gulp Taks
 */


// Lint scripts
gulp.task('lint:scripts', function() {
    return gulp.src(config.scripts.lint)
        .pipe(plumber({ 'errorHandler': handleErrors }))
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'));
});

//concat and minify scripts
var scripts = Object.keys(config.scripts.input);
var scriptTasks = [];
scripts.forEach(function(scriptName) {
    var taskName = 'scripts:' + scriptName;
    scriptTasks.push(taskName);
    gulp.task(taskName, function() {
        return gulp.src(config.scripts.input[scriptName])
            .pipe(plumber({ 'errorHandler': handleErrors }))
            .pipe(concat(scriptName+'.js'))
            .pipe(gulpif(enabled.jsmin, uglify()))
            .pipe(gulp.dest(config.scripts.output))
            .pipe(browserSync.stream());
    });
});

gulp.task('build:scripts', scriptTasks);

// Process, lint, and minify Sass files
gulp.task('build:styles', function() {
    return gulp.src(config.styles.input)
        .pipe(plumber({ 'errorHandler': handleErrors }))
        .pipe(sass({
            outputStyle: 'expanded',
            sourceComments: true
        }))
        .pipe(postcss([
            autoprefixer({
                'browsers': ['last 2 version']
            })
        ]))
        .pipe(gulpif(enabled.cssmin, cssnano({
            safe: true,
            discardComments: {
                removeAll: true
            }
        })))
        .pipe(gulp.dest(config.styles.output))
        .pipe(browserSync.stream());
});


// Generate SVG sprites
gulp.task('build:svgs', function() {
    return gulp.src(config.svgs.input)
        .pipe(plumber({ 'errorHandler': handleErrors }))
        .pipe(tap(function(file, t) {
            if (file.isDirectory()) {
                var name = file.relative + '.svg';
                return gulp.src(file.path + '/*.svg')
                    .pipe(svgmin())
                    .pipe(svgstore({
                        fileName: name,
                        prefix: 'icon-',
                        inlineSvg: true
                    }))
                    .pipe(gulp.dest(config.svgs.output));
            }
        }))
        .pipe(svgmin())
        .pipe(gulp.dest(config.svgs.output))
        .pipe(browserSync.stream());
});

// Copy image files into output folder
gulp.task('build:images', function() {
    return gulp.src(config.images.input)
        .pipe(plumber({ 'errorHandler': handleErrors }))
        .pipe(gulp.dest(config.images.output))
        .pipe(browserSync.stream());
});

// Copy static files into output folder
gulp.task('build:static', function() {
    return gulp.src(config.static.input)
        .pipe(plumber({ 'errorHandler': handleErrors }))
        .pipe(gulp.dest(config.static.output))
        .pipe(browserSync.stream());
});

// Remove pre-existing content from output and test folders
gulp.task('clean:dist', function() {
    del.sync([
        config.output
    ]);
});

/**
 * Task Runners
 */

// Compile files
gulp.task('compile', [
    'lint:scripts',
    'clean:dist',
    'build:scripts',
    'build:styles',
    'build:images',
    'build:static',
    'build:svgs'
]);


// Compile files and generate docs (default)
gulp.task('default', [
    'compile',
    'watch'
]);

//watch files
gulp.task('watch', function() {
    browserSync.init({
        files: ['{inc,templates,components}/**/*.php', '*.php'],
        proxy: config.devUrl,
        snippetOptions: {
            whitelist: ['/wp-admin/admin-ajax.php'],
            blacklist: ['/wp-admin/**']
        }
    });
    gulp.watch([config.scripts.lint], ['build:scripts']);
    gulp.watch([config.styles.input], ['build:styles']);
    gulp.watch([config.images.input], ['build:images']);
    gulp.watch([config.static.input], ['build:static']);
    gulp.watch([config.svgs.input], ['build:svgs']);
});