var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    minifyCSS = require('gulp-minify-css');

gulp.task('default', ['css', 'js', 'fonts']);

gulp.task('css', function () {
    gulp.src(['assets/scss/style.scss'])
        .pipe(concat('style.css'))
        .pipe(sass({includePaths: ['node_modules/bootstrap-sass/assets/stylesheets/'], errLogToConsole: true}))
        .pipe(gulp.dest('web/css/'));

    gulp.src([
        'node_modules/select2/select2-bootstrap.css',
        'node_modules/bootstrap-datetimepicker-build/build/css/bootstrap-datetimepicker.css',
        'web/css/style.css'
    ])
        .pipe(concat('style.css'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('web/css/'));
});

gulp.task('js', function () {
    gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'node_modules/select2/select2.json',
        'node_modules/bootstrap-datetimepicker-build/node_modules/moment/moment.js',
        'node_modules/bootstrap-datetimepicker-build/build/js/bootstrap-datetimepicker.min.js',
        'assets/js/script.js'
    ])
        .pipe(concat('script.js'))
        .pipe(gulp.dest('web/js/'));

    // copy jquery.min.map
    gulp.src('node_modules/jquery/dist/jquery.min.map')
        .pipe(concat('script.min.map'))
        .pipe(gulp.dest('web/js/'));
});

gulp.task('fonts', function () {
    gulp.src('node_modules/bootstrap-sass/assets/fonts/**')
        .pipe(gulp.dest('web/fonts/'));
});

gulp.task('watch', function () {
    gulp.watch('assets/scss/*.scss', ['css']);
    gulp.watch('assets/js/*.js', ['js']);
});