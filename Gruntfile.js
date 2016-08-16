

module.exports = function(grunt) {

    grunt.initConfig({
        pot: {
            options: {
                text_domain: 'app',
                dest: './i18n/languages/id_ID/LC_MESSAGES/',
                keywords: [
                    '__:1',
                    '_e:1'
                ]
            },
            files: {
                src:  [ 
                    '**/*.php',
                    '!node_modules/**/*.php'
                ],
                expand: true
            }
        }
    });

    grunt.loadNpmTasks('grunt-pot')

};