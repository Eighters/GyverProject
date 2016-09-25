var config       = require('../config')
var gulp         = require('gulp')
var gulpSequence = require('gulp-sequence')

var productionTask = function(cb) {
    global.production = true
    gulpSequence('fonts', 'css', 'jsApp', 'revision', cb)
}

gulp.task('prod', productionTask)
module.exports = productionTask
