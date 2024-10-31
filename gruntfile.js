module.exports = function(grunt) {
    grunt.initConfig({
        po2mo: {
            files: {
                src: 'languages/*.po',
                expand: true
            }
        },
        pot: {
            options:{
                text_domain: 'smsapi',
                dest: 'languages/',
                msgmerge: true,
                overwrite: false,
                keywords: [
                    '__:1',
                    '_e:1'
                ]
            },
            files:{
                src:  [ '**/*.php' ],
                expand: true
            }
        }
    });

    grunt.loadNpmTasks('grunt-po2mo');

    grunt.registerTask('default', ['po', 'po2mo']);
};