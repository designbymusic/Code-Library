$(document).ready ( function (){

    if(($.browser.msie && parseInt($.browser.version) > 8) || !$.browser.msie){

    	$('#right').hide();

        var audio = document.getElementById('directions_clip');
        var duration = audio.duration;
        var textToggler = $('#textVersion');

        document.getElementById('directions_clip').addEventListener('ended', function(){
            this.currentTime = 0;
            showText(textToggler);
        }, false);


        
        textToggler.click ( function(e){
            e.preventDefault();
            textToggler = $(this);
            showText(textToggler);
        });
    }
});
function showText(toggler){
         $('#right').fadeIn(600, function(){
            
        }); 
        toggler.fadeOut(200)  
}