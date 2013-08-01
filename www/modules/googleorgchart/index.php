<?php
define('ROOT', dirname(dirname(__DIR__)));
define('MODULE', 'googleorgchart');
require ROOT.'/core/require/commun.php';

$orgChart = new WebGedVisu\modules\googleorgchart\orgChart($gedcom);

$datas2 = fopen('../../cache/js/orgChart.js',"w+");
fwrite($datas2, ' orgChart = ['.$orgChart->getOrgChart().'] ');
fclose($datas2);

$script = '
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript" src="../../cache/js/orgChart.js"></script>
    <script type="text/javascript" src="orgChart.js"></script>
';

head(); ?>
<?php foot($script); ?>