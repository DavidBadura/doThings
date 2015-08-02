var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');

var postcss = require('gulp-postcss');
var cssnext = require('cssnext');
var lost = require('lost');
var autoprefixer = require('autoprefixer');
var nestedcss = require('postcss-nested');

gulp.task('default', ['css', 'js', 'fonts']);

gulp.task('css', function () {

    var processors = [
        cssnext(),
        autoprefixer({browsers: ['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4']}),
        nestedcss,
        lost
    ];

    var files = [
        'node_modules/select2/select2.css',
        'assets/css/style.css',
        'node_modules/pickadate/lib/themes/default.css',
        'node_modules/pickadate/lib/themes/default.date.css',
        'node_modules/pickadate/lib/themes/default.time.css'
    ];

    gulp.src(['assets/css/style.css'])
        .pipe(postcss(processors))
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
        'node_modules/select2/select2.js',
        'node_modules/pickadate/lib/picker.js',
        'node_modules/pickadate/lib/picker.date.js',
        'node_modules/pickadate/lib/picker.time.js',
        'node_modules/moment/min/moment.min.js',
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
    //gulp.src('node_modules/bootstrap-sass/assets/fonts/**')
    //    .pipe(gulp.dest('web/fonts/'));
});

gulp.task('watch', function () {
    gulp.watch('assets/css/*.css', ['css']);
    gulp.watch('assets/js/*.js', ['js']);
});