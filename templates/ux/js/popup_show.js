jQuery( function($) {
	$(document).ready( function() {
		$("i[show-match-comments]").mouseover(function() {
			var match_id = $(this).attr("show-match-comments");
			var match_comments = $("div[comments-match-id='"+ match_id +"']");
			var pos = $(this).offset();
			pos.height = $(this).height();
			pos.width = $(this).width();
			var actualWidth = match_comments.width();
			var actualHeight = match_comments.height();
			var top = pos.top + pos.height / 2 - actualHeight / 2;
			var left = pos.left - actualWidth;
			left = left - 200;

			match_comments.show(10);
			match_comments.offset({
				top: top,
				left: left
			});
		});

		$("i[show-match-comments]").mouseout(function() {
			var match_id = $(this).attr("show-match-comments");
			var match_comments = $("div[comments-match-id='"+ match_id +"']");
			match_comments.hide(10);
		});
	});
});