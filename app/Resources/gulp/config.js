var argv = require('yargs').argv

var env = argv.env || 'dev'
var allowedEnv = ['dev', 'prod']

if (allowedEnv.indexOf(env) === -1) {
    console.log('ERROR, Unknown environment: "' + env + '"')
    console.log('Expected: [' + allowedEnv + ']')
    process.exit(1)
}

module.exports = {
    env: env,
    tasks: {
        css: {
            src: "./app/Resources/sass",
            dest: "./web/assets/css",
            extensions: [ "scss", "css" ],
            sass: {
                indentedSyntax: true,
                includePaths: [ "./node_modules/normalize.css" ]
            },
            autoprefixer: {
                browsers: [ "last 3 versions" ]
            }
        },
        javascript: {
            src: "./app/Resources/js",
            dest: "./web/assets/js",
            bowerDir: "./vendor"
        },
        html: {
            src: "./"
        },
        fonts: {
            src: "./vendor/materialize/dist/fonts",
            dest: "./web/assets/fonts",
            extensions: [ "woff2", "woff", "eot", "ttf", "svg" ]
        },
        revision: {
            src: [ "./web/assets/css/*.css", "./web/assets/js/**/*.js" ],
            base: "web",
            manifest: {
                name: "rev-manifest.json",
                path: "./web"
            }
        },
        clean: {
            css: "./web/assets/css",
            js: "./web/assets/js"
        }
    }
}
