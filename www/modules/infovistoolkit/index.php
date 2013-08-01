<?php
define('ROOT', dirname(dirname(__DIR__)));
if (!isset($_GET['type']) or !in_array($_GET['type'],array('spacetree', 'sunburst'))) {
    $type = 'sunburst';
}
else {
    $type = $_GET['type'];
}
define('MODULE', 'infovistoolkit_'.$type);
require ROOT.'/core/require/commun.php';



$arbre = new WebGedVisu\modules\infovistoolkit\Arbre($gedcom);

$json = fopen('../../cache/js/arbre-sunburst.js',"w+");
fwrite($json, 'json = '.json_encode($arbre->getArbre()));
fclose($json);

$head = '
    <link type="text/css" href="genealogie.css" rel="stylesheet" >
';
$script = '
    <!--[if IE]><script language="javascript" type="text/javascript" src="Jit/Extras/excanvas.js"></script><![endif]-->

    <!-- JIT Library File -->
    <script language="javascript" type="text/javascript" src="Jit/jit.js"></script>

    <!-- Example File -->
    <script language="javascript" type="text/javascript" src="'.$type.'.js"></script>

    <script language="javascript" type="text/javascript" src="../../cache/js/arbre-sunburst.js"></script>

';
head($head);
?>
<?php
foot($script);
?>