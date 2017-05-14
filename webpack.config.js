/**
 * Created by salamaashoush on 5/10/17.
 */
path = require('path');
module.exports = {
    entry: [
        path.resolve(__dirname, 'web/react/index'),
    ],
    output: {
        path: path.resolve(__dirname, 'web/builds'),
        filename: 'bundle.js',
        publicPath:'http://localhost:8080/builds/'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader",
                query: {
                    presets:[ 'latest', 'react', 'stage-2' ]
                }
            },
            {
                test: /\.scss$/,
                use: ["style-loader","css-loader","sass-loader"]
            },
            {
                test: /\.css$/,
                use: ["style-loader","css-loader"]
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
    devtool:'inline-source-map'
};