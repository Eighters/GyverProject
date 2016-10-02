var config = require('../config')
var gulp = require('gulp')

/**
 * This is the default recipes to build assets for application.
 */
var buildTask = function(cb) {
    var gulpSequence = require('gulp-sequence')

    gulpSequence( ['fonts', 'css', 'jsApp'], cb)
}

gulp.task('build', buildTask)
module.exports = buildTask
