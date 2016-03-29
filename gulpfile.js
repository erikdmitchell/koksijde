/**
 *
 * Gulpfile setup
 * @since 1.6.1
 * @package mdw-wp-theme
 *
 * Credit: https://ahmadawais.com/my-advanced-gulp-workflow-for-wordpress-themes/ - https://github.com/ahmadawais/Advanced-Gulp-WordPress
 */

// http://andy-carter.com/blog/a-beginners-guide-to-the-task-runner-gulp

// project configuration
var project 		= 'mdw-wp-theme', // Project name, used for build zip.
	url 					= 'mdwtheme.dev', // Local Development URL for BrowserSync. Change as-needed.
	build 				= './buildtheme/', // Files that you want to package into a zip go here
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

		// include specific files and folders
		'screenshot.png',

		// exclude files and folders
		'!node_modules/**/*',
	];

// Load plugins
var gulp       = require('gulp'), // Dink it down
	concat       = require('gulp-concat'), // To concatenate JS files - https://github.com/contra/gulp-concat
	ignore       = require('gulp-ignore'), // To ignore files in the stream based on file characteristics - https://github.com/robrich/gulp-ignore
	imagemin     = require('gulp-imagemin'), // Minifies PNG, JPEG, GIF and SVG images - https://github.com/sindresorhus/gulp-imagemin
	jshint			 = require('gulp-jshint'), // - https://www.npmjs.com/package/gulp-jshint
	livereload	 = require('gulp-livereload'), // - https://www.npmjs.com/package/gulp-livereload
	minifycss    = require('gulp-uglifycss'), // For CSS Minification - https://github.com/rezzza/gulp-uglifycss
	notify       = require('gulp-notify'); // sends messages - https://github.com/mikaelbr/gulp-notify
	plugins      = require('gulp-load-plugins'), // To automatically load in gulp plugins - https://github.com/jackfranklin/gulp-load-plugins
	plumber			 = require('gulp-plumber'), // Prevent pipe breaking caused by errors from gulp plugins - https://www.npmjs.com/package/gulp-plumber
	rename       = require('gulp-rename'), // To easily rename files - https://github.com/hparra/gulp-rename
	runSequence  = require('gulp-run-sequence'), // Run a series of dependent gulp tasks in order - https://github.com/OverZealous/run-sequence
	uglify       = require('gulp-uglify'), // Minifies JS files - https://github.com/terinjokes/gulp-uglify
	zip          = require('gulp-zip'); // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress! - https://github.com/sindresorhus/gulp-zip

// gulp.task('default', ['styles', 'plugins', 'scripts', 'images', 'watch']);

// our "default" function - needs to be tweaked //
gulp.task('default',function() {
	console.log('gulp');
});

// concatenate and minify JS Files //
gulp.task('scripts', function() {
  return gulp.src('assets/js/*.js')
    .pipe(concat('scripts.js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest(build));
});

// Build task that moves essential theme files for production-ready sites //
gulp.task('buildfiles', function() {
	return 	gulp.src(buildInclude)
 		.pipe(gulp.dest(build))
 		.pipe(notify({ message: 'Copy from buildFiles complete', onLast: true }));
});

/**
 * Images
 *
 * Look at src/images, optimize the images and send them to the appropriate place
*/
/*
gulp.task('images', function() {

// Add the newer pipe to pass through newer images only
	return 	gulp.src(['./assets/img/raw/**/*.{png,jpg,gif}'])
				.pipe(newer('./assets/img/'))
				.pipe(rimraf({ force: true }))
				.pipe(imagemin({ optimizationLevel: 7, progressive: true, interlaced: true }))
				.pipe(gulp.dest('./assets/img/'))
				.pipe( notify( { message: 'Images task complete', onLast: true } ) );
});
*/

/**
  * Clean tasks for zip
  *
  * Being a little overzealous, but we're cleaning out the build folder, codekit-cache directory and annoying DS_Store files and Also
  * clearing out unoptimized image files in zip as those will have been moved and optimized
 */

/*
 gulp.task('cleanup', function() {
 	return 	gulp.src(['./assets/bower_components', '**/.sass-cache','**/.DS_Store'], { read: false }) // much faster
		 		.pipe(ignore('node_modules/**')) //Example of a directory to ignore
		 		.pipe(rimraf({ force: true }))
		 		// .pipe(notify({ message: 'Clean task complete', onLast: true }));
 });
 gulp.task('cleanupFinal', function() {
 	return 	gulp.src(['./assets/bower_components','**/.sass-cache','**/.DS_Store'], { read: false }) // much faster
		 		.pipe(ignore('node_modules/**')) //Example of a directory to ignore
		 		.pipe(rimraf({ force: true }))
		 		// .pipe(notify({ message: 'Clean task complete', onLast: true }));
 });
*/


 /**
  * Zipping build directory for distribution
  *
  * Taking the build folder, which has been cleaned, containing optimized files and zipping it up to send out as an installable theme
 */
gulp.task('buildzip', function () {
	return gulp.src(build+'/**/')
		.pipe(zip(project+'.zip'))
		.pipe(gulp.dest('./'))
		.pipe(notify({ message: 'Zip task complete', onLast: true }));
 });



 /**
  * Gulp Default Task
  *
  * Compiles styles, fires-up browser sync, watches js and php files. Note browser sync task watches php files
  *
 */

/*
 // Package Distributable Theme
 gulp.task('build', function(cb) {
 	runSequence('styles', 'cleanup', 'vendorsJs', 'scriptsJs',  'buildFiles', 'buildImages', 'buildZip','cleanupFinal', cb);
 });

// a sample help function //
gulp.task('help', function() {
  console.log('MDW THEME GULP');
});
*/

/*
gulp.task('watch', function() {

  gulp.watch('css/src/*.scss', ['sass']);

  gulp.watch('js/src/*.js', ['js']);

  gulp.watch('img/src/*.{png,jpg,gif}', ['img']);

});
*/

/*
var plumberErrorHandler = { errorHandler: notify.onError({

    title: 'Gulp',

    message: 'Error: <%= error.message %>'

  })

};
*/
/*
gulp.task('sass', function () {

  gulp.src('./css/src/*.scss')

    .pipe(plumber(plumberErrorHandler)) <--

    .pipe(sass())

    .pipe(gulp.dest('./css'))

    .pipe(livereload()); <--

});
*/