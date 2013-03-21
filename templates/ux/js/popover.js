jQuery( function($) {
	$(document).ready( function() {
		$("i[show-match-comments]").mouseover(function() {
			var match_id = $(this).attr("show-match-comments");
			var match_comments = $("div[comments-match-id='"+ match_id +"']");
			match_comments.show(10);
		});

		$("i[show-match-comments]").mouseout(function() {
			var match_id = $(this).attr("show-match-comments");
			var match_comments = $("div[comments-match-id='"+ match_id +"']");
			match_comments.hide(10);
		});
	});
});