var config      = require('../config')
if(!config.tasks.fonts) return

var changed     = require('gulp-changed')
var gulp        = require('gulp')
var path        = require('path')

var paths = {
    src: path.join(config.tasks.fonts.src, '/**/*.{' + config.tasks.fonts.extensions + '}'),
    dest: path.join(config.tasks.fonts.dest)
}

var fontsTask = function() {
    return gulp.src(paths.src)
        .pipe(changed(paths.dest))
        .pipe(gulp.dest(paths.dest))
}

gulp.task('fonts', fontsTask)
module.exports = fontsTask
