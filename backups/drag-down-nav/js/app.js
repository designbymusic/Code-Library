$(function(){
initNav()
});


function initNav(){
	var navHeight = $('.nav-main').outerHeight();
	console.log('-'+navHeight+'px');
	$('.nav-main').css({
		'top':'-'+navHeight+'px'
	});
}