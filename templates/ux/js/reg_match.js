// Скрипты для страницы регистрации матчей

jQuery( function($) {
	$(document).ready( function() {
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

		$("#away").bind('change', function (){
			var tid = $(this).val();
			$('#away_club_players_goal').html('<img src="/templates/fifa/img/ajax_load_bar.gif"/>');
			$.get('/match/get_away_club_players/' + tid, 0, function(data){
				$('#away_club_players_goal').html(data);
			});
		});

		// Убираем уже выбранных игроков из списка
		$(".home_players").focus(function(){
			$(this).attr('prev-value', $(this).val());
		}).change(function(){
				var prev = $(this).attr('prev-value');
				$(".home_players option[value='" + prev + "']").show();
				$(".home_players option[value='" + $(this).val() + "']").hide();
				$(this).children("option[value='" + $(this).val() + "']").show();
			});

		$(document).on("focus", ".away_players", function(){
			$(this).attr('prev-value', $(this).val());
		})
		$(document).on('change', ".away_players", function(){
			var prev = $(this).attr('prev-value');
			$(".away_players option[value='" + prev + "']").show();
			$(".away_players option[value='" + $(this).val() + "']").hide();
			$(this).children("option[value='" + $(this).val() + "']").show();
		});

		// Указываем на ошибку если у голов не выбран бомбардир
		$("button[type='submit']").click(function(){
			var error = false;
			$(".player_select_home, .player_select_away").each(function(){
				if($(this).find("input").val() != '' && $(this).find("select").val() == -1) {
					error = true;
				}
			});

			if(error) {
				alert("Проверьте правильность заполнения голов. Вероятно один из игроков не выбран.");
				return false;
			}

			return true;
		});

		$("#away").change();

        var match_score = function(){
            var home_goals = 0;
            var away_goals = 0;
            $(".player_select_home input.input-mini").each(function(number, element) {
                var value = $(element).val();
                if (/^[0-9]+$/.test(value)) {
                    home_goals += (+value);
                }
            })
            $(".player_select_away input.input-mini").each(function(number, element) {
                var value = $(element).val();
                if (/^[0-9]+$/.test(value)) {
                    away_goals += (+value);
                }
            })

            $(".match-result").html(home_goals + " - " + away_goals);
        }

        match_score();

        $(document).on("keyup", ".player_select_away input.input-mini, .player_select_home input.input-mini", match_score)
	});
});