var config = require('../config')
if(!config.tasks.revision) return

var gulp    = require('gulp')
var rev     = require('gulp-rev')

/**
 * Revision all asset files and
 * write a manifest file
 */
var revisionTask = function () {
    return gulp.src(config.tasks.revision.src, { base: config.tasks.revision.base })
        .pipe(gulp.dest(config.tasks.revision.base))
        .pipe(rev())
        .pipe(gulp.dest(config.tasks.revision.base))
        .pipe(rev.manifest({ path: config.tasks.revision.manifest.name }))
        .pipe(gulp.dest(config.tasks.revision.manifest.path))
}

gulp.task('revision', revisionTask)
module.exports = revisionTask
