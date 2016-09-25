var config = require('../config')
if(!config.tasks.html) return

var gulp        = require('gulp')
var browserSync = require('browser-sync')

var htmlTask = function () {
    return browserSync.reload()
}

gulp.task('html', htmlTask)
module.exports = htmlTask
