var config = require('../../config')
var gulp = require('gulp')

/**
 * Remove all files ignored by GIT
 * Used for testing provisioning from scratch
 */
var gitCleanTask = function () {
    var del = require('del')
    var vinylPaths = require('vinyl-paths')

    var sources = [
        'bin',
        'app/config/parameters.yml',
        'app/cache/*',
        '!app/cache/.gitkeep',
        'app/logs/*',
        '!app/logs/.gitkeep',
        'app/bootstrap.php.cache',
        'app/phpunit.xml',
        'app/config/deploy/production.rb',
        'app/config/deploy/staging.rb',
        'vendor',
        'web/assets/css',
        'web/assets/fonts',
        'web/assets/js',
        'web/bundles',
        'web/rev-manifest.json'
    ]

    return gulp.src(sources)
        .pipe(vinylPaths(del))
}

gulp.task('gitClean', gitCleanTask)
module.exports = gitCleanTask

