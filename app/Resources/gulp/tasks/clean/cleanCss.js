var config = require('../../config')
var gulp = require('gulp')

/**
 * Remove compiled Css files
 */
var cleanCssTask = function () {
    var del = require('del')
    var vinylPaths = require('vinyl-paths')

    return gulp.src(config.tasks.clean.css)
        .pipe(vinylPaths(del))
}

gulp.task('cleanCss', cleanCssTask)
module.exports = cleanCssTask

