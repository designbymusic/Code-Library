$(function(){
	$('#container').tweetable({username: 'designbymusic', time: true, limit: 25, replies: true, position: 'append'});
 	
});

$(window).load(function(){
	$('#container').isotope({ itemSelector : '.box', sortBy : 'random' });
});

function getFlickrFeed(u_id) {

  	return(feed)
}
//var flickrFeed = getFlickrFeed('40962351@N00');

var flickrFeed = (function(){
	var defaults={
		id: '40962351@N00'
	};	
	var feed = '';

	$.ajax({
		async: false,
		dataType: 'json',  	
		url:'http://api.flickr.com/services/feeds/photos_public.gne?format=json&id='+defaults.id+'&jsoncallback=?',  
		success:function(data) {
			feed = data;
		}
	});	
	return feed;
}());


var data = (function () {
        var ajaxResponse = '';
        $.ajax({url:"ajx_services", async:false, type:"post", success: function (data) {
                ajaxResponse = data;
        }, dataType:"json"}); 
        return ajaxResponse;
}());


console.log(flickrFeed)
/*function getFlickrFeed(u_id, limit, callback){

	var defaults={
		id: u_id
	};
	
	$.ajax({
	  url: 'http://api.flickr.com/services/feeds/photos_public.gne?format=json&id='+defaults.id+'&jsoncallback=?',
	  async: false,
	  dataType: 'json',
	  success: function (json) {
		callback(json);
	  }
	});
}
function returnFeed(feed){

	
	var processed_feed = [];
		$.each(feed.items, function(i,item){
			processed_feed.push({
				'time' 		: 	new Date(item.date_taken).getTime(),
				'thumbnail' : 	item.media.m,
				'content'	: 	item.description
			});
	});

	return processed_feed;
}
var flickrFeed = getFlickrFeed('40962351@N00', 20,returnFeed(function(output){
	console.log(output);
}));*/
