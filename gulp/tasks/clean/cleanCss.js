var config = require('../../config')
if(!config.tasks.clean) return

var gulp        = require('gulp')
var del         = require('del')
var vinylPaths  = require('vinyl-paths')

var cleanCssTask = function () {
    return gulp.src(config.tasks.clean.css)
        .pipe(vinylPaths(del))
}

gulp.task('cleanCss', cleanCssTask)
module.exports = cleanCssTask

