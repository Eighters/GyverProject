var config = require('../config')
if(!config.tasks.javascript) return

var gulp        = require('gulp')
var gulpif      = require('gulp-if')
var uglify      = require('gulp-uglify')
var browserSync = require('browser-sync')
var path        = require('path')

var paths = {
    src: path.join(config.tasks.javascript.src, '/**/*.js')
}

var javascriptAppTask = function () {
    return gulp.src(
        [
            paths.src
        ])
        .pipe(gulpif(global.production, uglify()))
        .pipe(gulp.dest(config.tasks.javascript.dest))
        .pipe(browserSync.stream())
}

gulp.task('jsApp', javascriptAppTask)
module.exports = javascriptAppTask
