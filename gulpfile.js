var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    minifyCSS = require('gulp-minify-css');

gulp.task('default', ['css', 'js', 'fonts']);

gulp.task('css', function () {
    gulp.src(['assets/scss/style.scss'])
        .pipe(concat('style.scss'))
        .pipe(sass({includePaths: ['node_modules/bootstrap-sass/assets/stylesheets/'], errLogToConsole: true}))
        .pipe(minifyCSS())
        .pipe(gulp.dest('web/css/'));
});

gulp.task('js', function () {
    gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'assets/js/script.js'
    ])
        .pipe(concat('script.js'))
        .pipe(gulp.dest('web/js/'));

    // copy jquery.min.map
    gulp.src('node_modules/jquery/dist/jquery.min.map')
        .pipe(gulp.dest('web/js/'));
});

gulp.task('fonts', function () {
    gulp.src('node_modules/bootstrap-sass/assets/fonts/bootstrap/*')
        .pipe(gulp.dest('web/fonts/'));
});

gulp.task('watch', function () {
    gulp.watch('assets/scss/*.scss', ['css']);
    gulp.watch('assets/js/*.js', ['js']);
});