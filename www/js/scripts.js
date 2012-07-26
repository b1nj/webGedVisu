/*
 * Dimension de l'application
 */
// Définition des dimensions de la boite #visualisation
var height = $(document).height() - 42;
var width = $(body).width() - 42;
$('body, #visualisation').height(height);

function resize() {
    width = $(body).width() - 42;
    height = $(document).height() - 42;
    if(typeof(view)!="undefined") {
        $('#visualisation').html('');
        view();
    }    
}
/*$(window).resize(function() {
    resize();
});*/

/*
 * Menu
 */
// Fermeture/ouverture du menu
$('#header_open').click(function () {
    $('#page, #slider-width').toggleClass('menu_actif');
});
// Menu déroulant
$('.deroulant').click(function () {
    $('#page nav li').removeClass('onglet_actif');
    $(this).parents('li').toggleClass('onglet_actif');
});

/*
 * Slider (curseur de redimmension)
 */
$("#slider-width").slider({
    range: "min",
    value: width,
    min: 300,
    max: 10000,
    stop: function(event, ui) { 
        $('body, #visualisation').width(ui.value);
        resize();
    }
});
$("#slider-height").slider({
    orientation: "vertical",
    range: "min",
    value: height,
    min: 100,
    max: 10000,
    stop: function(event, ui) { 
        $('body, #visualisation').height(ui.value); 
        resize();
    }
});
// Dimension des sliders
$("#slider-height").height(height - 60);
$("#slider-width").width(width - 20);

