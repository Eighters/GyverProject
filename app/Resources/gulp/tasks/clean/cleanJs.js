var config = require('../../config')
var gulp = require('gulp')

/**
 * Remove compiled JavaScript files
 */
var cleanJsTask = function () {
    var del = require('del')
    var vinylPaths = require('vinyl-paths')

    return gulp.src(config.tasks.clean.js)
        .pipe(vinylPaths(del))
}

gulp.task('cleanJs', cleanJsTask)
module.exports = cleanJsTask

