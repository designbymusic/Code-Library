<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Overlay test</title>
        <script type="text/javascript" src="scripts/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="scripts/jquery.cycle2.js"></script>
        <script type="text/javascript" src="scripts/jquery.cycle2.swipe.js"></script>
    </head>

    <body>

        <a href="pages/page-1.php" class="launch-overlay">Launch overlay</a>

        <script type="text/javascript">
            $(document).ready(function(){

                $('a.launch-overlay').contentOverlaySlider({
                    scrollTransition: 'scrollHorz'
                });
            });

            (function($){

                $.fn.extend({

                    //pass the options variable to the function
                    contentOverlaySlider: function(options) {

                        var $trigger            = $(this);
                        var $window             = $(window);
                        var $currentCycleSlide  = 0;

                        //Set the default values, use comma to separate the settings, example:
                        var defaults = {
                            animateSpeed:   200,
                            overlayOpacity:     1,
                            scrollTransition:   'fade',
                            nextSlide:          '.cycle-next',
                            previousSlide:      '.cycle-prev'
                        }

                        var options =  $.extend(defaults, options);

                        return this.each(function() {
                            var o = options;

                            $trigger.bind( 'click', launchOverlay );


                            // Build the overlay element, append to the body and fade in
                            function launchOverlay(event, callback){

                                event.preventDefault();

                                var overlay = buildOverlay();
                            }

                            // Remove the overlay element from the page
                            function closeOverlay(event, callback){
                                event.preventDefault();
                                $('#overlay').animate({
                                    'opacity': 0
                                }, o.animateSpeed, function(){
                                    $(this).remove();
                                });
                            }

                            // Build the overlay html and return as jQuery object
                            function buildOverlay(){

                                var overlay_html = '<div id="overlay"><span class="close"></span><div id="loader"></div></div>';

                                $(overlay_html).appendTo(document.body).animate({
                                    'opacity': o.overlayOpacity
                                }, o.animateSpeed, function(){
                                    $('#loader').fadeIn(o.animateSpeed / 2, function(){
                                        var frameContent = getContent($($trigger).attr('href'), function(data){
                                            var overlay_content = '<div id="overlay-content">'+data+'</div>';
                                            $(overlay_content).hide().appendTo('#overlay').fadeIn(o.animateSpeed, function(){
                                                initSlides();
                                            });
                                        });
                                    });

                                });
                                return $(overlay_html);
                            }

                            // The ajax call to get the content of the requested page
                            function getContent(url, callback){

                                var page_content;
                                var data = [];
                                $.ajax({
                                  url: url,
                                  data: data,
                                  success: function(data){
                                      $('#loader').fadeOut(o.animateSpeed / 2, function(){
                                          callback(data);
                                      });
                                  },
                                  dataType: 'html'
                                });
                                return page_content;
                            }

                            // The ajax call to get the content of the requested page
                            function resizeSlides(){
                                $('.cycle-slideshow, .content-frame').css({
                                    'height' : $(window).height(),
                                    'width' : $(window).width()
                                });
                            }

                            // Init the slideshow
                            function initSlides(){
                                $(window).resize(function(){
                                    resizeSlides();
                                });
                                $('#overlay .close').bind( 'click', closeOverlay );
                                $('.cycle-slideshow').cycle({
                                    fx:      o.scrollTransition,
                                    next:    o.nextSlide,
                                    prev:    o.previousSlide,
                                    timeout: 0
                                });
                                $('.cycle-slideshow').on('cycle-before', function(event,opts){
                                    resizeSlides();
                                });
                                $('.cycle-slideshow').on('cycle-after', function(event,opts){

                                });
                            }
                        });
                    }
                });

            })(jQuery);



        </script>
        <style type="text/css">

            #overlay,
            #overlay-content{
                color: #fff;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #000;
                opacity: 0;
                z-index: 10000;
            }
            #overlay-content{
                position: absolute;
                opacity: 1;
                z-index: 10001;
            }
            #loader{
                background: url('images/loader.gif') no-repeat top right;
                display: none;
                left: 50%;
                position: absolute;
                top: 50%;
                height: 16px;
                width: 16px;
                z-index: 10002;
            }
            #overlay .close{
                background: url('images/close.png') no-repeat top right;
                cursor: pointer;
                display: block;
                height: 51px;
                position: fixed;
                right: 20px;
                top: 20px;
                width: 55px;
                z-index: 10002;
            }
        </style>


    </body>
</html>
