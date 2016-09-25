var config = require('../config')
var gulp   = require('gulp')
var path   = require('path')
var watch  = require('gulp-watch')

var paths = {
    cssSrc: path.join(config.tasks.css.src, '/**/*.{' + config.tasks.css.extensions + '}'),
    jsSrc: path.join(config.tasks.javascript.src, '/**/*.js'),
    htmlSrc: path.join(config.tasks.html.src, '/**/*.html.twig')
}

var watchTask = function() {
    // Watch Css changes
    gulp.watch(paths.cssSrc, ['css']);

    // Watch Js changes
    gulp.watch(paths.jsSrc, ['jsApp']);

    // Watch Html changes
    gulp.watch(paths.htmlSrc, ['html']);
}

gulp.task('watch', ['browserSync'], watchTask)
module.exports = watchTask
