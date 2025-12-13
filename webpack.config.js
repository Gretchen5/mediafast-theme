const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpackConfig = require("@wordpress/scripts/config/webpack.config");
const webpack = require('webpack');

// Extend the @wordpress webpack config and add the entry points.
module.exports = {
	...webpackConfig,
	...{
		mode: "production",
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
	},
};
