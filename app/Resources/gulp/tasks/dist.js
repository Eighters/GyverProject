var config = require('../config')
var gulp = require('gulp')

/**
 * This recipes build assets for non-dev environments (dist)
 * Run "build" recipes & add "revision" (Which is not required for development)
 */
var distTask = function(cb) {
    var gulpSequence = require('gulp-sequence')

    gulpSequence('build', 'revision', cb)
}

gulp.task('dist', distTask)
module.exports = distTask
