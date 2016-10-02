var config = require('../config')
var gulp = require('gulp')
var path = require('path')

var paths = {
    src: path.join(config.tasks.css.src, '/**/*.{' + config.tasks.css.extensions + '}'),
    dest: path.join(config.tasks.css.dest)
}

/**
 * Compile Sass into Css
 *
 * dev => Also write sourcemaps for better debugging
 * prod => Compact the Css output with cssnano minifier
 *
 * Note that cleanCss is executed before this recipes.
 */
var cssTask = function () {
    var gulpif = require('gulp-if')
    var sourcemaps = require('gulp-sourcemaps')
    var sass = require('gulp-sass')
    var handleErrors = require('../lib/handleErrors')
    var autoprefixer = require('gulp-autoprefixer')
    var cssnano = require('gulp-cssnano')
    var browserSync = require('browser-sync')

    return gulp.src(paths.src)
        .pipe(gulpif(config.env != 'prod', sourcemaps.init()))
        .pipe(sass(config.tasks.css.sass))
        .on('error', handleErrors)
        .pipe(autoprefixer(config.tasks.css.autoprefixer))
        .pipe(gulpif(config.env == 'prod', cssnano({autoprefixer: false})))
        .pipe(gulpif(config.env != 'prod', sourcemaps.write()))
        .pipe(gulp.dest(paths.dest))

        .pipe(gulpif(config.env != 'prod', browserSync.stream()))
}

gulp.task('css', ['cleanCss'], cssTask)
module.exports = cssTask

