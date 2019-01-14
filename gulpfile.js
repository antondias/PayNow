var gulp = require('gulp');
const fs = require('fs-extra');
var concatCss = require('gulp-concat-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var replace = require('gulp-string-replace');
var uglifycss = require('gulp-uglifycss');


gulp.task('copy-fonts', function () {
    return gulp.src(
        ['node_modules/@fortawesome/fontawesome-free/webfonts/**/*']
    ).pipe(gulp.dest('./src/assets/vendor/webfonts'));
});

gulp.task('replace-path', function () {
    return gulp.src(["./src/assets/vendor/treinetic-bundle.css"])
        .pipe(replace('../../../@fortawesome/fontawesome-free/webfonts/', './webfonts/'))
        .pipe(gulp.dest('./src/assets/vendor'))
});


gulp.task('empty', function (done) {
    fs.emptyDir('./src/assets/vendor');
    console.log(`➡ Contents of the 'dist' have been removed.`);
    done();
});

gulp.task('build-scripts', function () {
    return gulp.src(
        [
            './node_modules/jquery/dist/jquery.js',
            './node_modules/popper.js/dist/umd/popper.js',
            './node_modules/bootstrap/dist/js/bootstrap.js',
            './node_modules/bootstrap-validate/dist/bootstrap-validate.js',

        ]
    )
        .pipe(concat('treinetic-bundle.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./src/assets/vendor'))
});


gulp.task('build-css', function () {
    return gulp.src([
        './node_modules/bootstrap/dist/css/bootstrap.css',
        './node_modules/@fortawesome/fontawesome-free/css/all.css'
    ])
        .pipe(concatCss("treinetic-bundle.css"))
        .pipe(uglifycss({
            "maxLineLen": 80,
            "uglyComments": true
        }))
        .pipe(gulp.dest('./src/assets/vendor'));
});


gulp.task('build-scripts-custom', function () {
    return gulp.src(
        [
            './src/assets/js/script.js',
            './src/assets/js/requests.js',
            './src/assets/js/pay.js',

        ]
    )
        .pipe(concat('treinetic-script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./src/assets/vendor'))
});


gulp.task('build-css-custom', function () {
    return gulp.src([
        './src/assets/css/style.css',
        './src/assets/css/loader.css',
    ])
        .pipe(concatCss("treinetic-design.css"))
        .pipe(uglifycss({
            "maxLineLen": 80,
            "uglyComments": true
        }))
        .pipe(gulp.dest('./src/assets/vendor'));
});


gulp.task('build', gulp.series('empty', 'copy-fonts', 'build-scripts', 'build-css', 'build-scripts-custom', 'build-css-custom', 'replace-path'));

