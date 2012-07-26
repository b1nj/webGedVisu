<?php
define('ROOT', dirname(dirname(__DIR__)));
define('MODULE', 'googleorgchart');
require ROOT.'/core/require/commun.php';

$orgChart = new modules\googleOrgChart\orgChart($gedcom);

$script = <<<EOB
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1', {packages: ['orgchart']});
      function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows([
            {$orgChart->getOrgChart()}
        ]);
        // Create and draw the visualization.
        new google.visualization.OrgChart(document.getElementById('visualization')).
            draw(data, {allowHtml: true, size: 'small'});
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
EOB;

head();
?>
    <div id="visualization" style="overflow: auto;"></div>
<?php
foot($script);
?>