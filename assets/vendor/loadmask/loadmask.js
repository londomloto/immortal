
/**
 * Loading mask
 *
 * @author supernova
 */
(function($){

	var Loadmask = function(el, options) {
		this.el = $(el);
		this.init(options);
	};

	Loadmask.defaults = {
		transparent: false,
		template: [
			'<div class="spinner-overlay">',
		        '<div class="spinner">',
		              '<div class="rect1"></div>',
		              '<div class="rect2"></div>',
		              '<div class="rect3"></div>',
		              '<div class="rect4"></div>',
		              '<div class="rect5"></div>',
		        '</div>',
		    '</div>',
		]
	};

	Loadmask.prototype = {
		init: function(options) {
			this.options = $.extend(true, {}, Loadmask.defaults, options || {});
			this.mask = $([]);
		},

		show: function() {
			
			if ( ! this.mask.length) {
				this.mask = $(this.options.template.join(''));
			}
			
			if (this.options.transparent) {
				this.mask.addClass('transparent');
			} else {
				this.mask.removeClass('transparent');
			}

			this.mask.appendTo(this.el);

			// this.mask.width(this.el.width())
			// 		 .height(this.el.height());

			var spinner = this.mask.children('.spinner');

			spinner.css('margin-left', (this.mask.width() - spinner.width()) / 2 );
			spinner.css('margin-top', (this.mask.height() - spinner.height()) / 2 );

		},

		hide: function() {
			if (this.mask.length) {
				this.mask.fadeOut($.proxy(function(){
					this.mask.remove();
					this.mask = $([]);
				}, this));
				
				
			}
		}
	};

	$.fn.mask = function(options) {
		var obj = $(this).data('loadmask');
		if ( ! obj) {
			$(this).data('loadmask', (obj = new Loadmask(this, options)));
		}
		obj.show(options);
	};

	$.fn.unmask = function() {
		var obj = $(this).data('loadmask');
		obj && obj.hide();
	};

}(jQuery));