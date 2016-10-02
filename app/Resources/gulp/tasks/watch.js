var config = require('../config')
var gulp   = require('gulp')
var path   = require('path')

var paths = {
    cssSrc: path.join(config.tasks.css.src, '/**/*.{' + config.tasks.css.extensions + '}'),
    jsSrc: path.join(config.tasks.javascript.src, '/**/*.js'),
    htmlSrc: path.join(config.tasks.html.src, '/**/*.html.twig')
}


/**
 * Run "build" recipes & start "watch" for any changes to:
 * - Sass / Css
 * - JavaScript
 * - Twig views
 *
 * Also run a "browserSync" server that you can use with your phone for responsive debugging
 * see "browserSync" recipes for more details
 */
var watchTask = function() {
    var watch  = require('gulp-watch')

    // Watch Css changes
    gulp.watch(paths.cssSrc, ['css'])

    // Watch Js changes
    gulp.watch(paths.jsSrc, ['jsApp'])

    // Watch Html changes
    gulp.watch(paths.htmlSrc, ['html'])
}

gulp.task('watch', ['browserSync'], watchTask)
module.exports = watchTask
