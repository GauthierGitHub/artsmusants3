//https://openclassrooms.com/forum/sujet/probleme-d-affichage-plugin-masonry

var container = document.querySelector('#container_item');
var msnry = new Masonry( container, {
  // options
  columnWidth: 200,
  itemSelector: '.item',
  fitWidth: true,
  containerStyle: null
});
 
$('.item img').load(function(){
        var msnry = new Masonry( container, {
        itemSelector: '.item',
        "columnWidth": 200,
    });
})