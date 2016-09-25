var config = require('../../config')
if(!config.tasks.clean) return

var gulp        = require('gulp')
var del         = require('del')
var vinylPaths  = require('vinyl-paths')

var cleanJsTask = function () {
    return gulp.src(config.tasks.clean.js)
        .pipe(vinylPaths(del))
}

gulp.task('cleanJs', cleanJsTask)
module.exports = cleanJsTask

