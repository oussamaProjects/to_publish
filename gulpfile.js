const 	gulp 			= require('gulp'),
		plumber 		= require('gulp-plumber'),
		sass 			= require('gulp-sass'),
		concat 			= require('gulp-concat'),
		uglify 			= require('gulp-uglify'),
		imagemin 		= require('gulp-imagemin'),
		cleanCSS 		= require('gulp-clean-css'),
		sourcemaps		= require('gulp-sourcemaps'),
		autoprefixer	= require('gulp-autoprefixer'),
		watch 			= require('gulp-watch'),
		rename 			= require("gulp-rename"),
		livereload 		= require('gulp-livereload'),
		sassdoc 		= require('sassdoc'),
		cmq          	= require('gulp-combine-media-queries'),
		ignore      	= require('gulp-ignore'), // Helps with ignoring files and directories in our run tasks
		rimraf      	= require('gulp-rimraf'), // Helps with removing files and directories in our run tasks
		zip         	= require('gulp-zip'), // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress!
		cache       	= require('gulp-cache'),
		runSequence 	= require('gulp-run-sequence');


const 	dir_sass 		= ['./public/js/libs/bootstrap/sass/**/*','./public/js/libs/font-awesome/scss/font-awesome.scss','./public/sass/**/*.scss'],
	 	style_sass 		= './public/sass/to_publish-public.scss',
		dir_css 		= './public/css',
		dir_image 		= './images/**/*', 
		images_comp		= '../../prod/imagemin',
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
							'**/*.po',
							'**/*.mo',
							'**/*.png',
							'**/*.jpg',
							'**/*.jpeg',
							'**/*.pdf',
							'**/*.ico',
							'**/*.pdf',

							// include specific files and folders
							'screenshot.png', 

							// exclude files and folders
							'!.git',
							'!.gitignore',
							'!README.md',
							'!gulpfile.js',
							'!package.json',
							'!sftp-config.json',
							'!node_modules/**/*',
							'!bower_components/**/*',
							'!js/libs/**/*',
							'!assets/bower_components/**/*',
							'!style.css.map',
							'!assets/js/custom/*',
							'!Ndossier/**/*',
							'!assets/css/patrials/*',
							'!css/Ndossier/**/*',
							'!js/Ndossier/**/*',
							'!**/*.map',

						];



var sassOptions = {
	errLogToConsole: true,
	outputStyle: 'expanded'
};
var sassOptionsCompact = {
	errLogToConsole: true,
	outputStyle: 'compact'
};
var sassOptionsCompressed = {
	errLogToConsole: true,
	outputStyle: 'compressed'
};

 
gulp.task('generate_style', function() {
	gulp.src(style_sass)
	.pipe(sourcemaps.init())
	.pipe(sass(sassOptions).on('error', sass.logError))
	.pipe(autoprefixer())
	.pipe(plumber())
	.pipe(gulp.dest(dir_css))
	.pipe(cleanCSS())
	.pipe(rename({suffix: '.min'}))
	.pipe(sourcemaps.write('/maps'))
	.pipe(gulp.dest(dir_css))
	.pipe(livereload());
});

//Watch task
gulp.task('default',function() {
	gulp.watch( dir_sass, [ 'generate_style' ] 	); 
	livereload.listen();
});


gulp.task('imagemin', function(){
	gulp.src(dir_image)
	.pipe(imagemin())
	.pipe(plumber())
	.pipe(gulp.dest(images_comp))
});


gulp.task('uglifyJS', function () {
	gulp.src('js/global.js')
	.pipe(uglify())
	.pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('js/'))
	.pipe(livereload());

});

gulp.task('uglifyJsHome', function () {
	gulp.src('home/js/script.js')
	.pipe(uglify())
	.pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('home/js/'))	
	.pipe(livereload());

}); 

var sassdocOptions = {
	dest: './public/sassdoc'
};

gulp.task('sassdoc', function () {
	return gulp
	.src(dir_sass)
	.pipe(sassdoc(sassdocOptions))
	.resume();
});





/**
* Clean tasks for zip
* Being a little overzealous, but we're cleaning out the build folder, codekit-cache directory and annoying DS_Store files and Also
* clearing out unoptimized image files in zip as those will have been moved and optimized
*/
gulp.task('cleanup', function() {
	return 	gulp.src(['./assets/bower_components', '**/.sass-cache','**/.DS_Store'], { read: false }) // much faster
	 		.pipe(ignore('node_modules/**')) //Example of a directory to ignore
	 		.pipe(rimraf({ force: true }));
});


gulp.task('cleanupFinal', function() {
	return 	gulp.src(['./assets/bower_components', '**/.sass-cache','**/.DS_Store'], { read: false }) // much faster
	 		.pipe(ignore('node_modules/**')) //Example of a directory to ignore
	 		.pipe(rimraf({ force: true }));
});


/**
* Build task that moves essential theme files for production-ready sites
* buildFiles copies all the files in buildInclude to build folder - check variable values at the top
* buildImages copies all the images from img folder in assets while ignoring images inside raw folder if any
*/
gulp.task('buildFiles', function() {
	return gulp.src(buildInclude)
		 		.pipe(gulp.dest(build));
});

gulp.task('del', function(){
     return del(build+'/**', {force:true});
});

/**
* Zipping build directory for distribution
* Taking the build folder, which has been cleaned, containing optimized files and zipping it up to send out as an installable theme
*/
gulp.task('buildZip', function () {
	// return 	gulp.src([build+'/**/', './.jshintrc','./.bowerrc','./.gitignore' ])
	return 	gulp.src(build+'/**/')
	.pipe(zip('tmsa.zip'))
	.pipe(gulp.dest('./'));
});


// Package Distributable Theme
gulp.task('build', function(cb) {
	runSequence('cleanup', 'buildFiles', 'buildZip', 'cleanupFinal', cb);
});
