module.exports = {
	entry: './src/js/app.js',
	output: {
		path: __dirname + '/public/',
		filename: 'bundle.js'
	},
	devtool: process.env.DEV ? 'cheap-module-eval-source-map' : false,
	module: {
		loaders: [{
			test: /\.js$/,
			loader: 'babel-loader',
			exclude: /node_modules/,
			query: {
				presets: ['es2015', 'react']
			}
		}, {
			test: /\.scss$/,
			loaders: ['style', 'css', 'sass']
		}]
	}
}