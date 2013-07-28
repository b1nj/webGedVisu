$(function() {
    $( "#visualisation" ).interface({draggable : false});
});

/*
 * Dimension de l'application
 */
/*
// Définition des dimensions de la boite #visualisation
var height = $(window).height() - 42;
var width = $(window).width() - 42;
var height1 = height;
var width1 = width;
$('#visualisation').height(height);

$('#visualisation').wrap('<div id="visualisation_content" />');

var topOffset;
$('#visualisation').draggable({
    cursor: "move",
    drag: function(event, ui) {
        console.log(ui.offset.top);
        topOffset = ui.offset.top;
    }
});
$('#visualisation_content').css('width', width + 'px');
$('#visualisation_content').css('height', height + 'px');

function resize() {
    $('#visualisation').width(width);
    $('#visualisation').height(height);
    if(typeof(view)!="undefined") {
        $('#visualisation').html('');
        view();
    }
}

$('#visualisation_content').bind('mousewheel', function(event, delta) {
    width = width + (delta > 0 ? 250 : -250);
    height = height + (delta > 0 ? 250 : -250);
    $("#slider-height").slider({ value: height });
    $("#slider-width").slider({ value: width });
    resize();
    return false;
});
/*
$(window).resize(function() {
    var height = $(window).height() - 42;
    var width = $(window).width() - 42;
    $('#visualisation').height(height);
    $('#visualisation_content').css('width', width + 'px');
    $('#visualisation_content').css('height', height + 'px');
    resize();
});
*/
/*
 * Menu
 */
/*
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
/*
$("#slider-width").slider({
    range: "min",
    value: width,
    min: 300,
    max: 10000,
    stop: function(event, ui) {
        width = ui.value;;
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
        height = ui.value;
        resize();
    }
});
// Dimension des sliders
$("#slider-height").height(height - 100);
$("#slider-width").width(width - 60);

*/