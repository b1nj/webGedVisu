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

    $("#visualisation")
        .interface({
            draggable: false,
            zoom: true,
            zoomOptions: {
                wSlide : false,
                hMin: 10,
                hMax: 80,
                hValue: 30,
                pas: 5,
                change: function(event, ui) {
                    sb.config.levelDistance = ui.hValue;
                    sb.refresh();
                }
        }
    });

    height = $("#visualisation").height();
    width = $("#visualisation").width();
    //init Sunburst
    sb = new $jit.Sunburst({
        //id container for the visualization
        injectInto: 'visualisation',
        //Distance between levels
        levelDistance: 30,
        width: width,
        height: height,
            //enable panning
            Navigation: {
              enable:true,
              panning:true,
            },
        //Change node and edge styles such as
        //color, width and dimensions.
        Node: {
          overridable: true,
          //type: useGradients? 'gradient-multipie' : 'multipie'
        },
        //Select canvas labels
        //'HTML', 'SVG' and 'Native' are possible options
        Label: {
          type: labelType
        },
        //Change styles when hovering and clicking nodes
        NodeStyles: {
          enable: true,
          type: 'Native',
          stylesClick: {
            'color': '#33dddd'
          },
          stylesHover: {
            'color': '#dd3333'
          }
        },
        //Add tooltips
        Tips: {
          enable: true,
          onShow: function(tip, node) {
            var html = "<div class=\"tip-title\">" + node.data.description + "</div>";
            tip.innerHTML = html;
          }
        }
    });
    //load JSON data.
    sb.loadJSON(json);
    //compute positions and plot.
    sb.refresh();
    //end

});