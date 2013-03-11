jQuery( function($) {
	$(document).ready( function() {
//		$('#content').height($('#center').height()-250);
//		$('#vmenu').height($('#center').height()-250);

//		colums();
//
//		$(window).resize(colums());
		var i_players_adds = 2;
		var plform;
		var i_goals_home = 1;
		var i_goals_away = 1;
		var form;
		var tmp_i;



		$('#add_player_button').click(function addplayerform()
		{
			plform = '';
			plform += '<li class="">';
			plform += '<div class="input_left">';
			plform += '<label class="desc" for="last_name['+ i_players_adds +']">';
			plform += 'Фамилия';
			plform += '</label>';
			plform += '<div>';
			plform += '<input class="field text lite" type="text" name="last_name['+ i_players_adds +']" id="last_name['+ i_players_adds +']">';
			plform += '</div>';
			plform += '</div>';
			plform += '<div class="input_right">';
			plform += '<label class="desc" for="first_name['+ i_players_adds +']">';
			plform += 'Имя';
			plform += '</label>';
			plform += '<div>';
			plform += '<input class="field text lite" type="text" name="first_name['+ i_players_adds +']" id="first_name['+ i_players_adds +']">';
			plform += '</div>';
			plform += '</div>';
			plform += '</li>';
			i_players_adds++;
			$('ul#players').append(plform);
		});

		$(".add_goal_select_home").click(function (){
			var $showed = $(".player_select_home:first");
			tmp_i = 1;
			while($showed.css('display') != 'none')
			{
				$showed = $showed.next();
				if(tmp_i++ > 7)
					break;
			}
			$showed.show('fast');
			i_goals_home++;
			if(i_goals_home == 7)
				$(this).hide();
		});

		$(document).on("click", ".add_goal_select_away", function(){
			var $showed = $(".player_select_away:first");
			tmp_i = 1;
			while($showed.css('display') != 'none')
			{
				$showed = $showed.next();
				if(tmp_i++ > 7)
					break;
			}
			$showed.show('fast');
			i_goals_away++;
			if(i_goals_away == 7)
				$(this).hide();
		});
//		$(".add_goal_select_away").click(function (){
//
//		});

		$("#away").bind('change', function (){
			var tid = $(this).val();
			$('#away_club_players_goal').html('<img src="/templates/fifa/img/ajax_load_bar.gif"/>');
			$.get('/match/get_away_club_players/' + tid, 0, function(data){
				$('#away_club_players_goal').html(data);
			});
		});

		// Ссылка с подтверждением
		$("a.confirm").click(function(){
			return confirm($(this).attr('confirm_text'));
		});

		// Включем везде где надо визуальный редактор
		$('.wysiwyg').wysihtml5('init', {lists: false});


		// Всплывающие подсказки
//		$(".popup_profile").corner("5px;")
//		$('.club_info_in_profile').popup({trigger: '.popup_profile_trigger', popup: '.popup_profile'});
//		$('.club_info_in_profile').each(function ()
//		{
//			// options
//			var distance = 10;
//			var time = 250;
//			var hideDelay = 500;
//
//			var hideDelayTimer = null;
//
//			// tracker
//			var beingShown = false;
//			var shown = false;
//
//			var trigger = $('.popup_profile_trigger', this);
//			var popup = $('.popup_profile', this).css('opacity', 0);
//
//			//наводим на элемент
//			$([trigger.get(0), popup.get(0)]).mouseover(function ()
//			{
//				// показывать элемент
//				if (hideDelayTimer) clearTimeout(hideDelayTimer);
//
//				// не вызывают анимации снова, если уже виден
//				if (beingShown || shown) {
//					return;
//				} else {
//					beingShown = true;
//
//					// сбросить позиции всплывающее окно
//					popup.css({
//						top: distance - popup.height() - 12,
//						left: 0,
//						display: 'block' // Приносит всплывающих назад, чтобы посмотреть
//					})
//
//					// (we're using chaining on the popup) now animate it's opacity and position
//					.animate({
//						top: '-=' + distance + 'px',
//						opacity: 1
//					}, time, 'swing', function() {
//						// once the animation is complete, set the tracker variables
//						beingShown = false;
//						shown = true;
//					});
//				}
//			}).mouseout(function ()
//			{
//				// reset the timer if we get fired again - avoids double animations
//				if (hideDelayTimer) clearTimeout(hideDelayTimer);
//				hideDelayTimer = setTimeout(function () {
//					hideDelayTimer = null;
//					popup.animate({
//						top: '-=' + distance + 'px',
//						opacity: 0
//					}, time, 'swing', function () {
//						//отслеживаем переменные
//						shown = false;
//
//						popup.css('display', 'none');
//					});
//				}, hideDelay);
//			});
//		});

		// Комментарии к матчу всплывающие окна
//		$("div.match_comments_wrapper").popup_light({trigger: '.comments_views', popup: '.match_commnets'});

		// Подтверждение/Регистрация матча
		$("input.match_confirm").click(function(){
			$(this).parent().hide();
			$(this).parent().parent().append('<li><img src="/templates/fifa/img/ajax_load_bar.gif"/></li>');
		});
		$("input#match_register").click(function(){
			$(this).hide();
			$(this).parent().parent().append('<li><img src="/templates/fifa/img/ajax_load_bar.gif"/></li>');
		});
	});
});