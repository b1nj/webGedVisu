 
    google.load('visualization', '1', {packages: ['orgchart']});
    function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows(
            orgChart
        );
        // Create and draw the visualization.
        new google.visualization.OrgChart(document.getElementById('visualisation')).
            draw(data, {allowHtml: true, size: 'small'});
    }
    google.setOnLoadCallback(drawVisualization);

$(function() { 
        $("#visualisation")
            .interface({
                draggable: true,
                zoom: true,
                zoomOptions: {
                    wMin: 1,
                    wMax: 20,
                    wValue: 10,
                    hMin: 1,
                    hMax: 20,
                    hValue: 10,
                    pas: 1,
                    change: function(event, ui) {
                        ui.element
                            .css('transform', 'scale(' + (ui.wValue / 10) + ', ' + (ui.hValue / 10) + ')');
                    }
                },                    
            })
            .css('transform-origin', '0 0');
});
