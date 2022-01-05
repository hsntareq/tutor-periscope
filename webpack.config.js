const path = require( 'path' );
const fs = require('fs');
const TerserPlugin = require( 'terser-webpack-plugin' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );

module.exports = ( env, options ) => {

	const mode = options.mode || 'development';

	const config = {
		mode,
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: 'babel-loader',
				}
			],
		},
		devtool: 'source-map',
	};

	if ( 'production' === mode ) {
		var minimizer = env!='build' ? 
			new TerserPlugin({
					terserOptions: {},
					minify: ( file ) => {
						const uglifyJsOptions = {
							sourceMap: true,
						};
						return require( 'uglify-js' ).minify( file, uglifyJsOptions );
					},
				}) :
			new TerserPlugin({
				terserOptions: {},
				minify: ( file ) => {
					const uglifyJsOptions = {
						sourceMap: false,
					};
					return require( 'uglify-js' ).minify( file, uglifyJsOptions );
				},
			});

		config.devtool = false;
		config.optimization = {
			minimize: true,
			minimizer: [
				minimizer,
				new CssMinimizerPlugin(),
			],
		};
	}

	// Get react blueprints
	const assets_dir = __dirname + '/assets';
	var src_blueprints = [
		{
			dest_path: './assets/js',
			src_files: {
				'frontend' : './assets/src/frontend/frontend.js',
				'backend' : './assets/src/backend/backend.js',
			}
		}
	];

	fs.readdirSync(assets_dir).forEach(function(dir_name){
		var src_dir = assets_dir+'/'+dir_name+'/assets/src';

		if(!fs.existsSync(src_dir) || !fs.lstatSync(src_dir).isDirectory()){
			// src directory not found
			return;
		}


		var blueprint = {
			dest_path: './assets/js',
			src_files: {}
		}

		fs.readdirSync(src_dir).forEach(function(file_name){
			var file = src_dir + '/' + file_name;
			var stat = fs.lstatSync(file);


			if(!stat.isFile() || path.extname(file_name)!='.js') {
				// Not react js files
				return;
			}

			var basename = path.parse(file).name;

			blueprint.src_files[basename] = './assets/src/'+file_name;
		});

		if(Object.keys(blueprint.src_files).length) {
			src_blueprints.push(blueprint);
		}
	});

	var configEditors = [];
	for(let i=0; i<src_blueprints.length; i++) {
		let {src_files, dest_path} = src_blueprints[i];

		configEditors.push(Object.assign({}, config, {
			name: 'configEditor',
			entry: src_files,
			output: {
				path: path.resolve(dest_path),
				filename: `[name].js`,
			},
		}))
	}

	var files = [].concat(...src_blueprints.map(m=>{
		return Object.keys(m.src_files).map(f=>{
			return m.dest_path+'/'+f+'.js';
		});
	}));

	fs.writeFileSync(__dirname+'/tutor-periscope.json', JSON.stringify({js_files:files}));

	return [ ...configEditors ];
};