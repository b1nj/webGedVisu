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



$arbre = new WebGedVisu\modules\d3\Arbre($gedcom);

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
head($head);
foot($script);
?>