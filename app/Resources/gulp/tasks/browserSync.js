var config = require('../config')
if (config.env != 'dev') {
    return
}

var gulp = require('gulp')

/**
 * Start a "browserSync" server
 * This is very useful for frontend development
 *
 * - You can use it to connect more clients like mobile phones, tablets, other Pc ect ...
 * - All clients connected are synced, and every action like click, mouse-scrolling, typing text in input) are sent to other clients
 *
 * The "watch" recipe is looking for changes in Twig, JavaScripts & Sass files & notify browserSync who reload pages on every synced clients
 */
var browserSyncTask = function() {
    var browserSync = require('browser-sync')

    browserSync.init({
        proxy: 'gyverproject.dev'
    });
}

gulp.task('browserSync', ['build'], browserSyncTask)
module.exports = browserSyncTask
