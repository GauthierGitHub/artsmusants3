/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../css/pagetransitions.css');
require('../scss/app.scss');
require('../js/imageanimation.js');
require('../js/masonrybugfix.js');

//font awesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

//logo & images
require('../images/logo.jpg');
require('../images/france-flag-round-icon-16.png')
require('../images/united-kingdom-flag-round-icon-16.png')

var Masonry = require('masonry-layout');

var msnry = new Masonry('.grid', {
  // options...
});
var $ = require('jquery');
var jQueryBridget = require('jquery-bridget');
var Masonry = require('masonry-layout');
// make Masonry a jQuery plugin
jQueryBridget('masonry', Masonry, $);
// now you can use $().masonry()
/* basic use
$('.grid').masonry({
  columnWidth: 80
});
*/
//conflict with footer
//https://stackoverflow.com/questions/45727096/masonry-grid-overlapping-footer-content
var $container = $('#masonry-grid');
$container.imagesLoaded(function () {
  $('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: '.grid-sizer',
    percentPosition: true
  });
});

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');