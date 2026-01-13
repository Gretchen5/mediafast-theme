const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpackConfig = require("@wordpress/scripts/config/webpack.config");
const webpack = require('webpack');

// Extend the @wordpress webpack config and add the entry points.
// Determine mode: development for watch, production for build
const isProduction = process.env.NODE_ENV === 'production' || process.argv.includes('build');

module.exports = {
	...webpackConfig,
	...{
		mode: isProduction ? "production" : "development",
		devServer: {
			static: {
				directory: path.join(__dirname, "assets"),
			},
			client: {
				overlay: false,
			},
			// open: ["http://localhost"], // (Optional) Add your local domain here
			liveReload: true,
			hot: false,
			compress: true,
			devMiddleware: {
				writeToDisk: true,
			},
		},
		context: path.resolve(__dirname, "assets"),
		entry: ["./main.js", "./main.scss"],
		// jQuery support
		/*externals: {
			jquery: "jQuery",
		},*/
		module: {
			rules: [
				{
					test: /\.scss$/,
					use: [
						MiniCssExtractPlugin.loader,
						'css-loader',
						{
							loader: 'sass-loader',
							options: {
								sassOptions: {
									includePaths: [
										path.resolve(__dirname, 'assets/vendor-theme/scss')
									]
								}
							}
						}
					]
				},
				{
					test: /\.css$/i,
					use: [MiniCssExtractPlugin.loader, 'css-loader'],
				}
			]
		},
		plugins: [
			...webpackConfig.plugins,
			new webpack.ProvidePlugin({
				$: "jquery",
				jQuery: "jquery",
				"window.jQuery": "jquery",
			}),
			new MiniCssExtractPlugin({
				filename: 'main.css',
			}),
		],
		// Ensure watch mode works correctly
		watchOptions: {
			ignored: /node_modules/,
			poll: 1000, // Check for changes every second
		},
	},
};
