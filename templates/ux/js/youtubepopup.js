jQuery(function ($) {
	$(document).ready(function () {
		$("a.youtube").YouTubePopup({
			autoplay: 0,
			clickOutsideClose: true
		});
	});
});