/**
 *
 * Gulpfile setup
 * @since 1.0.0
 * @package koksijde
 *
 */

// project configuration
var project 		= 'koksijde', // Project name, used for build zip.
	url 			= 'koksijde.dev', // Local Development URL for BrowserSync. Change as-needed.
	build 			= './buildtheme/', // Files that you want to package into a zip go here
	buildInclude 	= [
		// include common file types
		'**/*.php',
		'**/*.html',
		'**/*.css',
		'**/*.js',
		'**/*.svg',
		'**/*.ttf',
		'**/*.otf',
		'**/*.eot',
		'**/*.woff',
		'**/*.woff2',

		// include specific files and folders //
		'screenshot.png',
		'inc/js/*.min.js',
		'inc/admin/js/*.min.js',

		// exclude files and folders //
		'!node_modules/**/*', // node_modules
		'!inc/js/*', // js - handled by 'js'
		'!inc/admin/js/*', // admin js - handled by 'js'
		'!**/.DS_Store',
		'!.git',
		'!.gitignore',
		'!gulp.js',
		'!package.json'
	];

// Load plugins
var gulp		 = require('gulp'), // Dink it down
	concat       = require('gulp-concat'), // To concatenate JS files - https://github.com/contra/gulp-concat
	ignore       = require('gulp-ignore'), // To ignore files in the stream based on file characteristics - https://github.com/robrich/gulp-ignore
	imagemin     = require('gulp-imagemin'), // Minifies PNG, JPEG, GIF and SVG images - https://github.com/sindresorhus/gulp-imagemin
	jshint		 = require('gulp-jshint'), // - https://www.npmjs.com/package/gulp-jshint
	livereload	 = require('gulp-livereload'), // - https://www.npmjs.com/package/gulp-livereload
	minifycss    = require('gulp-uglifycss'), // For CSS Minification - https://github.com/rezzza/gulp-uglifycss
	notify       = require('gulp-notify'); // sends messages - https://github.com/mikaelbr/gulp-notify
	plugins      = require('gulp-load-plugins'), // To automatically load in gulp plugins - https://github.com/jackfranklin/gulp-load-plugins
	rename       = require('gulp-rename'), // To easily rename files - https://github.com/hparra/gulp-rename
	uglify       = require('gulp-uglify'), // Minifies JS files - https://github.com/terinjokes/gulp-uglify
	zip          = require('gulp-zip'); // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress! - https://github.com/sindresorhus/gulp-zip


// our "default" function - needs to be tweaked //
gulp.task('default',function() {
	console.log('Drink it down!');
});

// minify js //
gulp.task('minjs', function() {
  return gulp.src(['inc/js/*.js', '!inc/js/*.min.js'])
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest(build+'inc/js/'));
});

// minify and build admin js //
gulp.task('minadminjs', function() {
  return gulp.src(['inc/admin/js/*.js', '!inc/js/*.min.js'])
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest(build+'inc/admin/js/'));
});

// moves minified js //
gulp.task('movejs', ['minjs'], function() {
	return gulp.src('inc/js/*.min.js')
		.pipe(gulp.dest(build+'inc/js/'));
});

// minifys and moves all js  (admin and regular //
gulp.task('js', ['minjs', 'minadminjs', 'movejs']);

// Build task that moves essential theme files for production-ready sites //
gulp.task('build', function() {
	return 	gulp.src(buildInclude)
 		.pipe(gulp.dest(build))
 		.pipe(notify({ message: 'Copy from build complete', onLast: true }));
});

// Zipping build directory for distribution //
gulp.task('zip', ['js', 'build'], function () {
	return gulp.src(build+'/**/')
		.pipe(zip(project+'.zip'))
		.pipe(gulp.dest('./'))
		.pipe(notify({ message: 'Zip task complete', onLast: true }));
 });

 // runs all our gulp tasks (in order) //
 gulp.task('runall', ['js', 'build', 'zip']);