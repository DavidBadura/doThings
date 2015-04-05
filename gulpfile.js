var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    minifyCSS = require('gulp-minify-css');

gulp.task('default', ['css', 'js', 'fonts']);

gulp.task('sass', function () {
    gulp.src('assets/scss/style.scss')
        .pipe(sass({includePaths: ['node_modules/bootstrap-sass/assets/stylesheets/'], errLogToConsole: true}))
        .pipe(gulp.dest('web/css/'))
    ;
});

gulp.task('css', ['sass'], function () {

    var files = [
        'node_modules/select2/select2-bootstrap.css',
        'node_modules/select2/select2.css',
        'assets/css/component.css',
        'web/css/style.css',
        'node_modules/pickadate/lib/themes/default.css',
        'node_modules/pickadate/lib/themes/default.date.css',
        'node_modules/pickadate/lib/themes/default.time.css'
    ];

    gulp.src(files)
        .pipe(concat('all.css'))
        .pipe(gulp.dest('web/css/'))
        .pipe(minifyCSS())
        .pipe(concat('all.min.css'))
        .pipe(gulp.dest('web/css/'))
    ;

    /* for select2 icons */
    gulp.src(['node_modules/select2/select2.png', 'node_modules/select2/select2x2.png'])
        .pipe(gulp.dest('web/css/'))
    ;
});

gulp.task('js', function () {
    gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'node_modules/select2/select2.js',
        'node_modules/pickadate/lib/picker.js',
        'node_modules/pickadate/lib/picker.date.js',
        'node_modules/pickadate/lib/picker.time.js',
        'assets/js/jquery.modal.js',
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