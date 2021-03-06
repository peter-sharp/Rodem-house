module.exports = function(grunt) {
  //load all Grunt tasks
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    less: {
      development: {
        files: {
          "css/styles.css": "css/styles.less"
        }
      }
    },

    watch: {
      scripts: {
        files: ['**/*.less'],
        tasks: ['less'],
        options: {
          spawn: false,
        },
      },
    },
  });
  // the default task (running "grunt" in console) is "watch"
  grunt.registerTask('default', ['less','watch']);

}
