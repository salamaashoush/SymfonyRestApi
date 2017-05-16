/**
 * Created by salamaashoush on 5/10/17.
 */
const CleanWebpackPlugin = require('clean-webpack-plugin')
const ExtractTextPlugin =require('extract-text-webpack-plugin');
const webpack = require('webpack');
const glob = require('glob');
const ManifestPlugin = require('webpack-manifest-plugin');

const path = require('path');
module.exports = {
    devtool: 'source-map',
    entry: {
        vendor: path.resolve(__dirname, 'web/react/vendor'),
        main: path.resolve(__dirname, 'web/react/index')
    },
    target: 'web',
    output: {
        path: path.resolve(__dirname, 'web/dist'),
        publicPath: '/',
        filename: '[name].[hash].js'
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader",
                query: {
                    presets:[ 'latest', 'react', 'stage-2' ]
                }
            },
            {test: /\.scss$/, use: ExtractTextPlugin.extract({
                use:['css-loader','sass-loader'],
                fallback:['style-loader']
                })
            },
            {test: /\.css$/, use: ExtractTextPlugin.extract({
                use:['css-loader'],
                fallback:['style-loader']
            })
            },
            {
                test:   /\.(png|gif|jpe?g|svg?(\?v=[0-9]\.[0-9]\.[0-9])?)$/i,
                loader: 'file-loader',
                options:{
                    name:'images/[name].[hash].[ext]'
                }
            }
        ]
    },
    devServer: {
        hot: true,
        contentBase: './web/',
        headers: { "Access-Control-Allow-Origin": "*" }
    },
    devtool:'inline-source-map',
    plugins: [
        new ManifestPlugin(),
        new CleanWebpackPlugin(['dist'], {
            root:   path.resolve(__dirname,'web'),
            verbose:  true,
            dry:      false
        }),
        new ExtractTextPlugin('[name][hash].css'),
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vendor',
        }),
        new webpack.LoaderOptionsPlugin({
            minimize:true,
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
                drop_console: false,
            },
            sourceMap: true
        })
    ]
};