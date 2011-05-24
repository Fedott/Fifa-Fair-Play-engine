;(function($) {
	$.fn.popup = function (options) {
		// Defaults
		if( !options ) var options = {};
		if( options.distance == undefined ) options.distance = 20;
		if( options.time == undefined ) options.time = 250;
		if( options.hideDelay == undefined ) options.hideDelay = 500;
		if( options.trigger == undefined ) options.trigger = '.popup_trigger';
		if( options.popup == undefined ) options.popup = '.popup_content';
		if( options.absolute_container == undefined ) options.absolute_container = false;
		
		return this.each(function()
		{
			var hideDelayTimer = null;
			
			var beingShown = false;
			var shown = false;
			
			var trigger = $(options.trigger, this);
			var popup = $(options.popup, this).css('opacity', 0);
			//наводим на элемент
			$([trigger.get(0), popup.get(0)]).mouseover(function ()
			{
				// показывать элемент
				if (hideDelayTimer) clearTimeout(hideDelayTimer);

				// не вызывают анимации снова, если уже виден
				if (beingShown || shown) {
					return;
				} else {
					beingShown = true;

					// сбросить позиции всплывающее окно
					popup.css({
						top: options.distance - popup.height() - 12,
						left: 0,
						display: 'block' // Приносит всплывающих назад, чтобы посмотреть
					})

					// (we're using chaining on the popup) now animate it's opacity and position
					.animate({
						top: '-=' + options.distance + 'px',
						opacity: 1
					}, options.time, 'swing', function() {
						// once the animation is complete, set the tracker variables
						beingShown = false;
						shown = true;
					});
				}
			}).mouseout(function ()
			{
				// reset the timer if we get fired again - avoids double animations
				if (hideDelayTimer) clearTimeout(hideDelayTimer);
				hideDelayTimer = setTimeout(function () {
					hideDelayTimer = null;
					popup.animate({
						top: '-=' + options.distance + 'px',
						opacity: 0
					}, options.time, 'swing', function () {
						//отслеживаем переменные
						shown = false;

						popup.css('display', 'none');
					});
				}, options.hideDelay);
			});
		});
	}
	
	$.fn.popup_light = function (options) {
		if( ! options ) var options = {};
		if( options.time == undefined ) options.time = 250;
		if( options.popup == undefined ) options.popup = '.popup';
		if( options.trigger == undefined ) options.trigger = '.popup_trigger';
		
		return this.each(function()
		{
			var popup = $(options.popup, this);
			var trigger = $(options.trigger, this);
			trigger.mouseover(function(e)
			{
				var top_mouse = e.pageY;
				var left_mouse = e.pageX;
				
				popup.show().css('opacity', 0);
//				alert(popup.css('top'));
				
				var width = popup.width();
				var height = popup.height();
				popup.css({
					top: $(this).position().top - height - 15,
					left: left_mouse - width / 2
				}).animate({
					opacity: 1
				}, options.time, 'swing', function(){
//					alert(popup.css('top'));
				});
			}).mouseout(function()
			{
				popup.hide();
			});
		})
	}
})(jQuery);