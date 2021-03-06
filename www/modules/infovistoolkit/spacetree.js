$(function() {
    var labelType, useGradients, nativeTextSupport, animate;


    (function() {
      var ua = navigator.userAgent,
          iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
          typeOfCanvas = typeof HTMLCanvasElement,
          nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
          textSupport = nativeCanvasSupport
            && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
      //I'm setting this based on the fact that ExCanvas provides text support for IE
      //and that as of today iPhone/iPad current text support is lame
      labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
      nativeTextSupport = labelType == 'Native';
      useGradients = nativeCanvasSupport;
      animate = !(iStuff || !nativeCanvasSupport);
    })();

var self2;
    $.widget( "wgvD3.spacetree", {
        // default options
        options: {
            //id of viz container element
            injectInto: 'visualisation',
            //set duration for the animation
            duration: 800,
            //set animation transition type
            transition: $jit.Trans.Quart.easeInOut,
            //set distance between node and its children
            levelDistance: 50,
            width: $("#visualisation").width(),
            height: $("#visualisation").height(),
            //enable panning
            Navigation: {
              enable:true,
              panning:true
            },
            orientation:'bottom',

            //set node and edge styles
            //set overridable=true for styling individual
            //nodes or edges
            Node: {
                height: 80,
                width: 150,
                type: 'rectangle',
                color: '#aaa',
                overridable: true
            },

            Edge: {
                type: 'bezier',
                overridable: true
            },

            //This method is called on DOM label creation.
            //Use this method to add event handlers and styles to
            //your node.
            onCreateLabel: function(label, node){
                label.id = node.id;
                label.innerHTML = node.data.description;
                label.onclick = function(){
                    //console.log($.wgvD3.spacetree);
                    //$.wgvD3.spacetree.prototype.st.onClick(node.id);
                    //$("#visualisation").spacetree()
                    // TODO: virer self2
                    self2.st.onClick(node.id);
                };
                //set label styles
                var style = label.style;
                style.width = 150 + 'px';
                style.height = 77 + 'px';
                style.cursor = 'pointer';
                style.color = '#333';
                style.fontSize = '0.8em';
                style.textAlign= 'center';
                style.paddingTop = '3px';
            },

            //This method is called right before plotting
            //a node. It's useful for changing an individual node
            //style properties before plotting it.
            //The data properties prefixed with a dollar
            //sign will override the global node style properties.
            onBeforePlotNode: function(node){
                //add some color to the nodes in the path between the
                //root node and the selected node.
                if (node.selected) {
                    node.data.$color = "#ff7";
                }
                else {
                    delete node.data.$color;
                    //if the node belongs to the last plotted level
                    if(!node.anySubnode("exist")) {
                        //count children number
                        var count = 0;
                        node.eachSubnode(function(n) { count++; });
                        //assign a node color based on
                        //how many children it has
                        node.data.$color = ['#aaa', '#baa', '#caa', '#daa', '#eaa', '#faa'][count];
                    }
                }
            },

            //This method is called right before plotting
            //an edge. It's useful for changing an individual edge
            //style properties before plotting it.
            //Edge data proprties prefixed with a dollar sign will
            //override the Edge global style properties.
            onBeforePlotLine: function(adj){
                if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                    adj.data.$color = "#eed";
                    adj.data.$lineWidth = 3;
                }
                else {
                    delete adj.data.$color;
                    delete adj.data.$lineWidth;
                }
            }
        },
        // the constructor
        _create: function() {
            this.st = new $jit.ST(this.options);
            self2 = this;
            //load json data
            this.st.loadJSON(json);
            //compute node positions and layout
            this.st.compute();
            //optional: make a translation of the tree
            this.st.geom.translate(new $jit.Complex(-200, 0), "current");
            //emulate a click on the root node.
            this.st.onClick(this.st.root);
            //end
        },

        _setOption: function(key, value){
            this.st.config[key] = value;
        },

        refresh: function () {
            this.st.refresh();
        }
    });


    $("#visualisation")
        .interface({
            draggable: true,
            zoom: true,
            zoomOptions: {
                wSlide : false,
                hMin: 20,
                hMax: 50,
                hValue: "30",
                pas: 1,
                change: function(event, ui) {
                    ui.element
                    .spacetree();
                }
            }
        })
        .spacetree();


});