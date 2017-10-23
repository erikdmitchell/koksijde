var gulp = require('gulp'); // gulp
var sass = require('gulp-sass'); // sass
var gutil = require('gulp-util'); // ultitly
var livereload = require('gulp-livereload'); // auto reload
var autoprefixer = require('autoprefixer'); // adds browser prefixes
var cssdeclsort = require('css-declaration-sorter'); // orders our css within the class/id
var plumber = require('gulp-plumber'); // Prevent pipe breaking caused by errors from gulp plugins
var postcss = require('gulp-postcss'); // PostCSS is a tool for transforming styles with JS plugins
var rename = require('gulp-rename'); // rename files
	
var onError = function(err) {
	// eslint-disable-next-line no-console
	console.log('An error ocurred: ', gutil.colors.magenta(err.message));
	gutil.beep();
	this.emit('end');
}

function notifyLiveReload(event) {
	var fileName = require('path').relative(__dirname, event.path);
	livereload.changed(fileName);
}

gulp.task('default', function() {
  console.log('Good Day!');
});

gulp.task('sass', function() {
	var processors = [
		autoprefixer({browsers: ['last 2 versions']}),
		cssdeclsort({order: 'alphabetically'}),
	];
	return gulp.src('./sass/style.scss')
		.pipe(plumber({errorHandler: onError}))
		.pipe(sass({ outputStyle: 'nested' }))
		.pipe(postcss(processors))
		.pipe(rename("style.css"))
		.pipe(gulp.dest('./'))
		.pipe(livereload())
});

gulp.task('watch', ['sass'], function() {		
	livereload.listen();
	gulp.watch('sass/**/*.scss', ['sass']);
	gulp.watch('sass/**/*.sass', ['sass']);
});