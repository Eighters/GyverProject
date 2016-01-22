'use strict';

var gulp    = require('gulp');
var concat  = require('gulp-concat');
var uglify  = require('gulp-uglify');
var sass    = require('gulp-sass');

var config  = {bowerDir: './vendor'};


gulp.task( 'default',
    [ 'build', 'watch' ]
);

gulp.task( 'build',
    [ 'js', 'sass' ]
);


/**
 * Merge and compile JS files
 */
gulp.task( 'js', function() {
    gulp.src(
        [
            config.bowerDir + '/jquery/dist/jquery.min.js',
            config.bowerDir + '/materialize/dist/js/materialize.min.js',
            config.bowerDir + '/sweetalert/dist/sweetalert.min.js',
            'app/Resources/js/**/*.js'
        ])
        .pipe(concat('gyver_main.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./web/assets/js'));
});

/**
 * Merge SASS files and compile in CSS
 */
gulp.task( 'sass', function() {
    gulp.src(
        [
            'app/Resources/sass/**/*.scss'
        ])
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./web/assets/css'));
});

/**
 * Watch Change in Js and Sass Files
 */
gulp.task('watch', function () {
    gulp.watch('app/Resources/sass/**/*.scss', ['sass']);
    gulp.watch('app/Resources/js/**/*.js', ['js']);
});
