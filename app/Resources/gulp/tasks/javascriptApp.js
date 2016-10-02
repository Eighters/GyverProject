var config = require('../config')
var gulp = require('gulp')
var path = require('path')

var paths = {
    src: path.join(config.tasks.javascript.src, '/**/*.js'),
    dest: path.join(config.tasks.javascript.dest)
}

/**
 * Compile application JavaScripts sources
 *
 * dev  => Parse code with jsHinter and output Errors & Warnings
 * prod => Also Uglify (minify) the code
 *
 * Note that jsVendor is executed before this recipes.
 */
var jsAppTask = function () {
    var gulpif = require('gulp-if')
    var uglify = require('gulp-uglify')
    var jshint = require('gulp-jshint')
    var stylish = require('jshint-stylish')
    var browserSync = require('browser-sync')

    return gulp.src(paths.src)
        .pipe(gulpif(config.env === 'prod', uglify()))
        .pipe(gulp.dest(paths.dest))

        .pipe(gulpif(config.env != 'prod', jshint()))
        .pipe(gulpif(config.env != 'prod', jshint.reporter(stylish)))

        .pipe(gulpif(config.env != 'prod', browserSync.stream()))
}

gulp.task('jsApp', ['jsVendor'], jsAppTask)
module.exports = jsAppTask
