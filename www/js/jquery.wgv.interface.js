$(function() {
    $.widget( "wgv.interface", {
        // default options
        options: {
            draggable: false,
            menuAutoOpen: true,
            zoom : false,
            zoomOptions : {},

            // callbacks
            menuOpen: null,
            menuClose: null,
            refresh: null,
            resize: null,
        },

        // Définition des dimensions de la boite #visualisation
        height: $(window).height() - 42,
        width: $(window).width() - 42,
        menuIsOpen: null,

         // the constructor
        _create: function() {
            var self = this;

            this.element.css('min-height', this.height + 'px').
            wrap('<div id="visualisation_content" />');

            if (this.options.zoom) {
                this.element.zoom(this.options.zoomOptions);

                this.element.on('change', function() {
                	console.log('ttt');
                	self._trigger("change2", event, self);
                });
            }
            if (this.options.draggable) {
                this.draggable();
            }
            this.resize();

            this._on($('#header_open'), {
                click: function() {
                    if (this.menuIsOpen) {
                        this.menuClose();
                    } else {
                        this.menuOpen();
                    }
                }
            });
            if (this.options.menuAutoOpen) {
                this.menuOpen();
            }
            $('.deroulant').on('click',
                function() {
                    $li = $(this).parents('li').toggleClass('onglet_actif');
                    $('#page nav li').not($li).removeClass('onglet_actif');
                }
            );
            this.element.on('click',
                function() {
                    $('#page nav li').removeClass('onglet_actif');
                }
            );
        },

        _refresh: function() {
            this.element.css('min-height', this.height + 'px');
            if (this.options.draggable) {
                $('#visualisation_content').css('width', this.width + 'px').
                css('height', this.height + 'px');
            }
            this._trigger("refresh");
        },

        draggable: function() {
            $('#visualisation_content').css('width', this.width + 'px').
            css('height', this.height + 'px');
            $("#visualisation_content").addClass('draggable');
            this.element.draggable({ cursor: "move" });
            return this;
        },

        resize: function() {
            this._on($(window), {
                resize: function() {
                    this.height = $(window).height() - 42;
                    this.width = $(window).width() - 42;
                    this._refresh();
                    this._trigger("resize");
                }
            });
            return this;
        },

        // Fermeture/ouverture du menu
        menuOpen: function(options) {
            $('#page, #slider-width').addClass('menu_actif');
            this.menuIsOpen = true;
            this._trigger( "menuOpen" );
			return this;            
        },

        menuClose: function(options) {
            $('#page, #slider-width').removeClass('menu_actif');
            this.menuIsOpen = false;
            this._trigger("menuClose");
        	return this;
        },
    });
});