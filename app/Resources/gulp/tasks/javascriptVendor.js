var config = require('../config')
var gulp = require('gulp')

/**
 * Get JavaScripts libs used in project & merge it into a single file
 * We don't need to minify js, they already is (use *.min.js)
 *
 * Note that cleanJs recipes is executed before this recipes
 */
var javascriptVendorTask = function () {
    var concat = require('gulp-concat')

    return gulp.src(
        [
            config.tasks.javascript.bowerDir + '/jquery/dist/jquery.min.js',
            config.tasks.javascript.bowerDir + '/materialize/dist/js/materialize.min.js',
            config.tasks.javascript.bowerDir + '/sweetalert/dist/sweetalert.min.js'
        ])
        .pipe(concat('main.js'))
        .pipe(gulp.dest(config.tasks.javascript.dest))
}

gulp.task('jsVendor', ['cleanJs'], javascriptVendorTask)
module.exports = javascriptVendorTask
