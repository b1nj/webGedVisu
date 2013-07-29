$(function() {
    $.widget( "wgv.zoom", {
        // default options
        options: {
            wSlide: true,
            wMin: 1,
            wMax: 10,
            wValue: null,
            hSlide: true,
            hMin: 1,
            hMax: 10,
            hValue: null,
            pas: 1,
            // callbacks
            change: null
        },

        // the constructor
        _create: function() {
            this._mousewheel();
        },
        
        // initialisation
        _init: function() {
            if (this.options.hSlide) {
                this._showSlideHeight({
                    min: this.options.hMin,
                    max: this.options.hMax,
                    value: this.options.hValue,
                });
            }
            if (this.options.wSlide) {
                this._showSlideWidth({
                    min: this.options.wMin,
                    max: this.options.wMax,
                    value: this.options.wValue,
                });
            }
        },        

        _showSlideWidth: function(options) {
            var self = this;
            defaults = {
                min: 1,
                max: 10,
                value: null
            };
            options = $.extend( {}, defaults, options);

            options.value = options.value === null ? options.min : options.value;
            options.value = options.value == 'auto' ? $.wgv.interface.prototype.width : options.value;
            this.wValue = options.value;

            $("#slider-width").slider({
                range: "min",
                value: options.value,
                min: options.min,
                max: options.max,
                stop: function(event, ui) {
                    self.wValue = ui.value;
                    self._trigger("change", event, self);
                }
            }).width($.wgv.interface.prototype.width - 50);
        },

        _showSlideHeight: function(options) {
            var self = this;
            defaults = {
                min: 1,
                max: 10,
                value: null
            };
            options = $.extend( {}, defaults, options);

            options.value = options.value === null ? options.min : options.value;
            options.value = options.value == 'auto' ? $.wgv.interface.prototype.width : options.value;
            this.hValue = options.value;

            $("#slider-height").slider({
                orientation: "vertical",
                range: "min",
                value: options.value,
                min: options.min,
                max: options.max,
                stop: function(event, ui) {
                    self.hValue = ui.value;
                    self._trigger("change", event, self);
                }
            }).height($.wgv.interface.prototype.height - 50);
        },

        _mousewheel: function(options) {
            this._on($('#visualisation_content'), {
                mousewheel: function(event, delta) {
                    this.wValue = this.wValue + (delta > 0 ? this.options.pas : -this.options.pas);
                    if (this.wValue > this.options.wMax) {
                        this.wValue = this.options.wMax;
                    } else if (this.wValue < this.options.wMin) {
                        this.wValue = this.options.wMin;
                    }
                    this.hValue = this.hValue + (delta > 0 ? this.options.pas : -this.options.pas);
                    if (this.hValue > this.options.hMax) {
                        this.hValue = this.options.hMax;
                    } else if (this.hValue < this.options.hMin) {
                        this.hValue = this.options.hMin;
                    }
                    if (this.options.hSlide) {
                        $("#slider-height").slider({ value: this.hValue });
                    }
                    if (this.options.wSlide) {
                        $("#slider-width").slider({ value: this.wValue });
                    }
                    this._trigger("change", event, this);
                }
            });
        }
    });
});