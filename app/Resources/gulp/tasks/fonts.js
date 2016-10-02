var config = require('../config')
var gulp = require('gulp')
var path = require('path')

var paths = {
    src: path.join(config.tasks.fonts.src, '/**/*.{' + config.tasks.fonts.extensions + '}'),
    dest: path.join(config.tasks.fonts.dest)
}

/**
 * Copy fonts from vendor to dist folder
 */
var fontsTask = function() {
    var changed = require('gulp-changed')

    return gulp.src(paths.src)
        .pipe(changed(paths.dest))
        .pipe(gulp.dest(paths.dest))
}

gulp.task('fonts', fontsTask)
module.exports = fontsTask
