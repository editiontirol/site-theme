module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    copy: {
      'font-awesome': { expand: true, flatten: true, src: [ 'node_modules/font-awesome/fonts/*' ], dest: 'fonts/font-awesome' }
    },
    cssbeautifier : {
      files : ['*.css'],
      options : {
        indent: '  ',
        openbrace: 'end-of-line',
        autosemicolon: false
      }
    },
    jshint: {
      files: ['Gruntfile.js'],
      options: {
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    postcss: {
      options: {
        map: true,
        processors: [
          require('postcss-flexboxfixer')(),
          require('postcss-gradientfixer'),
          require('postcss-unprefix')(),
          require('postcss-remove-prefixes')(),
          require('autoprefixer')({
            browsers: ['> 5%', 'last 3 versions']
          })
        ]
      },
      dist: {
        src: '*.css'
      }
    },
    sass: {
      options: {
        loadPath: [
          'node_modules/support-for/sass',
          'node_modules/bourbon/app/assets/stylesheets'
        ],
        style: 'expanded'
      },
      dist: {
        files: [{
          'style.css' : 'style.scss'
        },
        {
          expand: true,
          cwd: 'inc/woocommerce/css',
          src: '*.scss',
          dest: 'inc/woocommerce/css',
          ext: '.css'
        }]
      }
    },
    scsslint: {
      options: {
        bundleExec: true,
        config: 'scss-lint.yml'
      },
      files: ['*.scss', '*/**/*.scss']
    },
    shell: {
      'update-caniuse-db': {
        command: 'npm update caniuse-db'
      }
    },
    watch: {
      build: {
        files: ['<%= watch.css.files %>', '<%= watch.js.files %>'],
        tasks: ['css', 'js']
      },
      css: {
        files: ['Gruntfile.js', '<%= cssbeautifier.files %>', '<%= scsslint.options.config %>', '<%= scsslint.files %>'],
        tasks: ['css']
      },
      js: {
        files: ['<%= jshint.files %>'],
        tasks: ['js']
      },
      test: {
        files: ['<%= watch.build.files %>'],
        tasks: ['test']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-cssbeautifier');
  grunt.loadNpmTasks('grunt-postcss');
  grunt.loadNpmTasks('grunt-scss-lint');
  grunt.loadNpmTasks('grunt-shell');

  grunt.registerTask('default', [
    'css',
    'js',
    'copy'
  ]);

  grunt.registerTask('css', [
    'sass',
    'shell:update-caniuse-db',
    'postcss:dist',
    'cssbeautifier'
  ]);

  grunt.registerTask('js', ['jshint']);

  grunt.registerTask('test', ['scsslint', 'jshint']);

};