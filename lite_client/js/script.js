$(document).ready(function() {
	var fadeTitle = false;
	var fadeTime = 200;

	$(".seriesVideos a").mouseenter(function() {
		if (fadeTitle)
		{
			$(this).children(".overlay").fadeIn({ queue: false, duration: fadeTime }, 'linear');
			$(this).children(".overlayContent").fadeIn({ queue: false, duration: fadeTime }, 'linear');
		}
		else
		{
			$(this).children(".overlay").show();
			$(this).children(".overlayContent").show();
		}
		
	});

	$(".seriesVideos a").mouseleave(function() {
		if (fadeTitle)
		{
			$(this).children(".overlay").fadeOut({duration: fadeTime }, 'linear');
			$(this).children(".overlayContent").fadeOut({duration: fadeTime }, 'linear');
		}
		else
		{
			$(this).children(".overlay").hide();
			$(this).children(".overlayContent").hide();
		}
		
	});
});