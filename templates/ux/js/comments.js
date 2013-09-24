jQuery(function ($) {
	$(document).ready(function () {
		if (comments_array.length) {
			$("#comment_tmpl").tmpl(comments_array).appendTo("div.comments");
		}
		var options = {
			dataType: 'json',
			beforeSubmit: function () {
				$("#comment_add_form").hide();
				$("#comment_add_loadbar").show();
			},
			success: function (respone) {
				if (respone.complete == true) {
					$("#comment_tmpl").tmpl(respone.comment).appendTo("div.comments");
					$("#comment_add_form").hide();
					$("#comment_add_loadbar").hide();
				}
				else {
					alert('При добавлении комментария возникли ошибки: ' + respone.errors);
					$("#comment_add_form").show();
					$("#comment_add_loadbar").hide();
				}
			}
		};
		$("#comment_add_form").ajaxForm(options);
	});
})