var config = require('../config')
var gulp = require('gulp')

/**
 * Reload the browser when changes are saved in some *.html.twig files
 * This is only useful during development.
 */
var htmlTask = function () {
    var browserSync = require('browser-sync')

    return browserSync.reload()
}

gulp.task('html', htmlTask)
module.exports = htmlTask
