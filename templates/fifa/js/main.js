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
		var form
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

		jQuery.listen("click", ".add_goal_select_away", function(){
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

		$("#away_id").bind('change', function load_players_away_team(){
			var tid = $(this).val();
			$('#away_team_players_goal').html('<img src="/templates/template/img/ajax_load_bar.gif"/>');
			$.get('/match/get_away_team_players/' + tid, 0, function(data){
				$('#away_team_players_goal').html(data);
			});
		});
	});
});