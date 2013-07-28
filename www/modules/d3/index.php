<?php
define('ROOT', dirname(dirname(__DIR__)));
if (!isset($_GET['type']) or !in_array($_GET['type'],array('tree', 'tree-radial'))) {
    $type = 'tree';
}
else {
    $type = $_GET['type'];
}
define('MODULE', 'd3_'.$type);
require ROOT.'/core/require/commun.php';



$arbre = new modules\d3\Arbre($gedcom);

$json = fopen('../../cache/js/arbre.json',"w+");
fwrite($json, json_encode($arbre->getArbre()));
fclose($json);

$head = '
    <script type="text/javascript" src="./d3/d3.v2.js"></script>
    <link type="text/css" rel="stylesheet" href="tree.css"/>
';
$script = '
    <script type="text/javascript" src="'.$type.'.js"></script>
    ';
if ($type == 'tree-radial') {
    $interface_options = '
    {
        draggable: true,
        zoom: true,
        zoomOptions: {
            wSlide : false,
            hMin: 100,
            hMax: 10000,
            hValue: "auto",
            pas: 500,
            change: function(event, ui) {
                $("#visualisation").width(ui.hValue).
                height(ui.hValue).
                html("");
                text = ui.hValue > 5000 ? true : false;
                view(text);
            }
        }
    }
    ';
} else {
    $interface_options = '
    {
        draggable: true,
        zoom: true,
        zoomOptions: {
            wMin: 300,
            wMax: 10000,
            wValue: "auto",
            hMin: 100,
            hMax: 10000,
            hValue: "auto",
            pas: 500,
            change: function(event, ui) {
                $("#visualisation").width(ui.wValue).
                height(ui.hValue).
                html("");
                text = ui.wValue > 3000 ? true : false;
                view(text);
            }
        }
    }
    ';
}

head($head);
foot($script, $interface_options);
?>