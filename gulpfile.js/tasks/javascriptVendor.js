var config = require('../config')
if(!config.tasks.javascript) return

var gulp        = require('gulp')
var concat      = require('gulp-concat')
var browserSync = require('browser-sync')

var javascriptVendorTask = function () {
    return gulp.src(
        [
            config.tasks.javascript.bowerDir + '/jquery/dist/jquery.min.js',
            config.tasks.javascript.bowerDir + '/materialize/dist/js/materialize.min.js',
            config.tasks.javascript.bowerDir + '/sweetalert/dist/sweetalert.min.js'
        ])
        .pipe(concat('main.js'))
        .pipe(gulp.dest(config.tasks.javascript.dest))
        .pipe(browserSync.stream())
}

gulp.task('jsVendor', javascriptVendorTask)
module.exports = javascriptVendorTask
