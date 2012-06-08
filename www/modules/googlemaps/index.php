<?php
define('ROOT', dirname(dirname(__DIR__)));
require ROOT.'/core/require/commun.php';


if (isset($_GET['MarkerClusterer'])) {
  $MarkerClusterer = $_GET['MarkerClusterer'];
}
else {
  $MarkerClusterer = false;
}

include 'carte_marqueur.php';

$config = '';
if ($MarkerClusterer) {
    $config = <<<EOB
        var mcOptions = {gridSize: 50, maxZoom: 15};
        var mc = new MarkerClusterer(carte, markers, mcOptions);
EOB;
}

$script = <<<EOB
        <!-- Elément Google Maps indiquant que la carte doit être affiché en plein écran et
        qu'elle ne peut pas être redimensionnée par l'utilisateur -->
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <!-- Inclusion de l'API Google MAPS -->
        <!-- Le paramètre "sensor" indique si cette application utilise détecteur pour déterminer la position de l'utilisateur -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <!-- http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/ -->
        <script type="text/javascript" src="markerclusterer_packed.js"></script>
        <script type="text/javascript">
            function initialiser() {
                var center = new google.maps.LatLng(46.225453,2.219238);
                //objet contenant des propriétés avec des identificateurs prédéfinis dans Google Maps permettant
                //de définir des options d'affichage de notre carte
                var options = {
                    center: center,
                    zoom: 6,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                
                //constructeur de la carte qui prend en paramêtre le conteneur HTML
                //dans lequel la carte doit s'afficher et les options
                var carte = new google.maps.Map(document.getElementById("carte"), options);
                var markers = [];
                //création du marqueur
                $marqueur
                $config
            }
            initialiser(); 
        </script>
EOB;

head();
?>
    <div id="carte" style="width:100%; height:100%"></div>
<?php
foot($script);
?>