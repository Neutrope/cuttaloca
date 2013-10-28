module.exports = (grunt) ->
  grunt.initConfig
    pkg: grunt.file.readJSON("package.json")

    watch:
      files: ['less/*.less']
      tasks: ['default']

    less:
      dev:
        options:
          paths: ['less']
        files:
          'app/webroot/css/app-style.min.css': 'less/app-style.less' # minifyしてない

      prod:
        options:
          paths: ['less']
          yuicompress: true
        files:
          'app/webroot/css/app-style.min.css': 'less/app-style.less'

  grunt.loadNpmTasks 'grunt-contrib'
  grunt.loadNpmTasks 'grunt-contrib-less'
  grunt.loadNpmTasks 'grunt-contrib-watch'
  grunt.registerTask 'default', ['less:dev']
  grunt.registerTask 'prod', ['less:prod']