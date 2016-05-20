var config       = require('../config')
var gulp         = require('gulp')
var gulpSequence = require('gulp-sequence')

var devTask = function(cb) {
    gulpSequence('css', ['jsVendor', 'jsApp'], 'watch',  cb)
}

gulp.task('dev', devTask)
module.exports = devTask
