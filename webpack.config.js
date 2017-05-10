/**
 * Created by salamaashoush on 5/10/17.
 */
let production = process.env.NODE_ENV === 'production';
path = require('path');
module.exports = {
    entry: [
        path.resolve(__dirname, 'web/js/index'),
    ],
    output: {
        path: path.resolve(__dirname, 'web/builds'),
        filename: 'bundle.js',
        publicPath: production ? '/builds/' : 'http://localhost:8080/builds/'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            },
            {
                test: /\.css$/,
                loader: "style!css"
            },
            {
                test:   /\.(png|gif|jpe?g|svg?(\?v=[0-9]\.[0-9]\.[0-9])?)$/i,
                loader: 'url?limit=10000',
            }
        ]
    },
    devServer: {
        hot: true,
        contentBase: './web/',
        headers: { "Access-Control-Allow-Origin": "*" }
    },
    devtool: production ? false : '#inline-source-map'
};