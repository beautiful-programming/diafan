'use strict';

const gulp = require('gulp'),
    gulpSass = require('gulp-sass'),
    gulpSourcemaps = require('gulp-sourcemaps'),
    gulpUglify = require('gulp-uglify'),
    cleanCSS = require('gulp-clean-css'),
    gulpNotify = require('gulp-notify'),
    gulpAutoprefixer = require('gulp-autoprefixer'),
    gulpRename = require('gulp-rename'),
    plumber = require('gulp-plumber'),
    gulpImagemin = require('gulp-imagemin'),
    gulpJpgRecomress = require('imagemin-jpeg-recompress'),
    gulpPngQuant = require('imagemin-pngquant'),
    gulpGcmq = require('gulp-group-css-media-queries'),
    webpack = require('webpack'),
    webpackStream = require('webpack-stream'),
    eslint = require("eslint"),
    babel = require('gulp-babel'),
    debug = require('gulp-debug'),
    browsersync = require('browser-sync').create(),
    clean = require('gulp-clean'),
    config = {
        src: './src/',
        dist: './dist/',
    },
    src = {
        sass: config.src + 'sass/style.scss',
        allSass: config.src + 'sass/**/*.scss',
        js: config.src + 'js/**/*.js',
        img: config.src + 'img/**/*.*'
    },
    dist = {
        sass: config.dist + 'css',
        js: config.dist + 'custom/js',
        img: config.dist + 'custom/img'
    };

let onError = (err) => {
    gulpNotify.onError({
        title: "Error in " + err.plugin,
        message: err.message
    })(err);
    this.emit('end');
};

let browserSync = done => {
    browsersync.init({
        proxy: "diafan"
    });
    done();
};

let browserSyncReload = done => {
    browsersync.reload();
    done();
};

let imgClean = () => {
    return gulp.src(dist.img, {read: false})
        .pipe(clean())
};

let img = () => {
    return gulp.src(src.img)
        .pipe(debug({title: 'building img:', showFiles: true}))
        .pipe(plumber({errorHandler: onError}))
        .pipe(gulp.dest(dist.img))
        .pipe(gulpImagemin([
            gulpImagemin.gifsicle({interlaced: true}),
            gulpJpgRecomress({
                progressive: true,
                max: 80,
                min: 70
            }),
            gulpPngQuant({quality: '80'}),
            gulpImagemin.svgo({plugins: [{removeViewBox: false}]})
        ]))
        .pipe(gulp.dest(dist.img));
};

let sass = () => {
    return gulp.src('./src/sass/style.scss')
        .pipe(gulpSourcemaps.init())
        .pipe(plumber({errorHandler: onError}))
        .pipe(gulpSass({outputStyle: 'expanded'}).on('error', gulpSass.logError))
        .pipe(gulpGcmq())
        .pipe(cleanCSS({
            level: {
                2: {
                    restructureRules: true
                }
            },
            compatibility: '*',
        }))
        .pipe(gulpAutoprefixer({
            overrideBrowserslist: ['last 35 versions']
        }))
        .pipe(gulpSourcemaps.write('./'))
        .pipe(gulp.dest(dist.sass))
        .pipe(browsersync.reload({stream:true}))
};

let jsLint = () => {
    return gulp
        .src([src.js, "./gulpfile.js"])
        .pipe(plumber())
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError());
};

let js = () => {
    return gulp.src(['node_modules/babel-polyfill/dist/polyfill.js', src.js])
        .pipe(gulpSourcemaps.init())
        .pipe(plumber({errorHandler: onError}))
        .pipe(babel({
            presets: ['@babel/preset-env'],
            plugins: ["syntax-async-functions","transform-regenerator"]
        }))
        .pipe(gulpUglify())
        .pipe(gulpRename({suffix: '.min'}))
        .pipe(gulpSourcemaps.write('.'))
        .pipe(gulp.dest(dist.js));
};

let watchFiles = () => {
    gulp.watch(src.allSass, gulp.series(sass));
    gulp.watch(src.js, gulp.series(js));
    // gulp.watch(src.img, gulp.series(img));
};

const watch = gulp.parallel(watchFiles, browserSync);
const imgTask = gulp.series(imgClean, img);

exports.imgTask = imgTask;
exports.watch = watch;
