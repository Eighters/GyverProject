if(global.production) return

var browserSync       = require('browser-sync')
var gulp              = require('gulp')
var config            = require('../config')

var browserSyncTask = function() {
  browserSync.init({
    proxy: '127.0.0.1'
  });
}

gulp.task('browserSync', browserSyncTask)
module.exports = browserSyncTask
