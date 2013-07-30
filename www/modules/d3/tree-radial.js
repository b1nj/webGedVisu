$(function() {
    $.widget( "wgvD3.treeRadial", {
        // default options
        options: {
            displayText: 'auto',
            widthMinForDisplayText: 3000,
            circleRayon: 4,
        },

         // the constructor
        _create: function() {
            this.view();
        },

        _setOption: function(key, value){
            this.options[key] = value;
        },

        view: function () {
            var self = this;

            height = this.element.height();
            width = this.element.width();

            var radius = (height > width ? width : height) / 2;

            var tree = d3.layout.tree()
                .size([360, radius])
                .separation(function(a, b) { return (a.parent == b.parent ? 1 : 2) / a.depth; });

            var diagonal = d3.svg.diagonal.radial()
                .projection(function(d) { return [d.y, d.x / 180 * Math.PI]; });

            var vis = d3.select("#visualisation").append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", "translate(" + radius + "," + radius + ")");

            d3.json("../../cache/js/arbre.json", function(json) {
                var nodes = tree.nodes(json);

                var link = vis.selectAll("path.link")
                    .data(tree.links(nodes))
                    .enter().append("path")
                    .attr("class", "link")
                    .attr("d", diagonal);

                var node = vis.selectAll("g.node")
                    .data(nodes)
                    .enter().append("g")
                    .attr("class", "node")
                    .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; })

                node.append("circle")
                    .attr("r", self.options.circleRayon);

                if (self.options.displayText === true || (self.options.displayText == 'auto' && self.options.widthMinForDisplayText <= width) ) {
                    node.append("text")
                        .attr("dx", function(d) { return d.x < 180 ? 8 : -8; })
                        .attr("dy", ".31em")
                        .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
                        .attr("transform", function(d) { return d.x < 180 ? null : "rotate(180)"; })
                        .text(function(d) { return d.name; });
                }
            });
        }
    });

    $("#visualisation")
        .interface({
            draggable: true,
            zoom: true,
            zoomOptions: {
                wSlide : false,
                hMin: 100,
                hMax: 10000,
                hValue: "auto",
                pas: 500,
                change: function(event, ui) {
                    ui.element
                        .width(ui.hValue)
                        .height(ui.hValue)
                        .html("")
                        .treeRadial('view');
                }
            }
        })
       .treeRadial();
});