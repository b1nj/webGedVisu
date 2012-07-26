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



$arbre = new modules\infoVisToolkit\Arbre($gedcom);

$head = '
    <link type="text/css" href="Jit/Examples/css/basen.css" rel="stylesheet" >
    <link type="text/css" href="Jit/genealogie.css" rel="stylesheet" >
';
$script = '    
    <!--[if IE]><script language="javascript" type="text/javascript" src="Jit/Extras/excanvas.js"></script><![endif]-->
    
    <!-- JIT Library File -->
    <script language="javascript" type="text/javascript" src="Jit/jit.js"></script>
    
    <!-- Example File -->
    <script language="javascript" type="text/javascript" src="Jit/'.$type.'.js"></script>
    
    <script type="text/javascript">
    var json = '.json_encode($arbre->getArbre()) .'
    /*init(json);*/
    </script>
';
head($head);
?> 
<?php
foot($script);
?>