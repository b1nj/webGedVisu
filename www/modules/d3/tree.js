$(function() {
	$.widget( "wgvD3.tree", {   
        // default options
        options: {
            displayText: 'auto',
            widthMinForDisplayText: 3000,
            circleRayon: 4,
            topMargin: 10,
            rightMargin: 150,
            bottomMargin: 10,
            leftMargin: 100,
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
		
		    var tree = d3.layout.tree()
				.size([height - self.options.topMargin - self.options.bottomMargin, width - self.options.leftMargin - self.options.rightMargin ]);
		
		    var diagonal = d3.svg.diagonal()
		        .projection(function(d) { return [d.y, d.x]; });
		
		    // TODO: enlever visualisation
		    var vis = d3.select("#visualisation").append("svg")
		        .attr("width", width)
		        .attr("height", height)
		    	.append("g")
		        .attr("transform", "translate(" + self.options.leftMargin + ", " + self.options.topMargin + ")");
		
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
			        .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
			
				node.append("circle")
			    	.attr("r", self.options.circleRayon);
			
				if (self.options.displayText === true || (self.options.displayText == 'auto' && self.options.widthMinForDisplayText <= width) ) {
		            node.append("text")
		                .attr("dx", function(d) { return d.children ? -8 : 8; })
		                .attr("dy", 3)
		                .attr("text-anchor", function(d) { return d.children ? "end" : "start"; })
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
                wMin: 500,
                wMax: 10000,
                wValue: "auto",
                hMin: 300,
                hMax: 10000,
                hValue: "auto",
                pas: 500,
                change: function(event, ui) {
                    $("#visualisation")
                        .width(ui.wValue)
                        .height(ui.hValue)
                        .html("")
                        .tree('view');
                }
            },
        })
	   .tree();
});