var config = require('../config')
var gulp = require('gulp')

/**
 * Used to implements "Cache Busting" system
 *
 * Revision all asset files & write a rev-manifest file
 * See https://knpuniversity.com/screencast/gulp/version-cache-busting
 */
var revisionTask = function () {
    var rev = require('gulp-rev')

    return gulp.src(config.tasks.revision.src, { base: config.tasks.revision.base })
        .pipe(gulp.dest(config.tasks.revision.base))
        .pipe(rev())
        .pipe(gulp.dest(config.tasks.revision.base))
        .pipe(rev.manifest({ path: config.tasks.revision.manifest.name }))
        .pipe(gulp.dest(config.tasks.revision.manifest.path))
}

gulp.task('revision', revisionTask)
module.exports = revisionTask
