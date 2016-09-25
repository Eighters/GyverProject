var config       = require('../config')
var gulp         = require('gulp')
var gulpSequence = require('gulp-sequence')

var devTask = function(cb) {
    gulpSequence('fonts', 'css', 'jsApp', 'revision',  cb)
}

gulp.task('dev', devTask)
module.exports = devTask
