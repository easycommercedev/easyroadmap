// webpack.config.js
const path = require('path');

module.exports = (env, argv) => {
    return {
        mode: argv.mode || 'development',
        entry: {
            'admin': path.resolve(__dirname, 'spa/admin/src/App.jsx'), // Entry point for the admin app
            'public': path.resolve(__dirname, 'spa/public/src/App.jsx'), // Adjust as needed
            'tailwind': path.resolve(__dirname, 'assets/common/css/tailwind.css') // Entry point for Tailwind CSS
        },
        output: {
            filename: '[name].bundle.js',
            path: path.resolve(__dirname, 'spa/build')
        },
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-react', '@babel/preset-env']
                        }
                    }
                },
                {
                    test: /\.css$/,
                    use: [
                        'style-loader',
                        'css-loader',
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    ident: 'postcss',
                                    plugins: [
                                        require('tailwindcss'),
                                        require('autoprefixer'),
                                    ],
                                },
                            },
                        },
                    ],
                }
            ]
        },
        resolve: {
            extensions: ['.js', '.jsx']
        },
        devtool: 'source-map',
    };
};