var config = require('../config')
if(!config.tasks.javascript) return

var gulp        = require('gulp')
var gulpif      = require('gulp-if')
var uglify      = require('gulp-uglify')
var browserSync = require('browser-sync')
var path        = require('path')
var jshint      = require('gulp-jshint')
var stylish     = require('jshint-stylish')


var paths = {
    src: path.join(config.tasks.javascript.src, '/**/*.js'),
    dest: path.join(config.tasks.javascript.dest)
}

var javascriptAppTask = function () {
    return gulp.src(paths.src)
        .pipe(gulpif(global.production, uglify()))
        .pipe(gulp.dest(paths.dest))

        .pipe(gulpif(!global.production, jshint()))
        .pipe(gulpif(!global.production, jshint.reporter(stylish)))

        .pipe(browserSync.stream())
}

gulp.task('jsApp', ['jsVendor'], javascriptAppTask)
module.exports = javascriptAppTask
