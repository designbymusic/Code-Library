<?php sleep(0); ?>
<script type="text/javascript">

</script>
<style type="text/css">
    .content-wrapper,
    .content-frame{
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 1000px;

        z-index: 10004;
    }
    .content-frame{
        display: none;
        top: 40px;
        z-index: 11000!important;
    }
    .frame-1{
        background: violet;
        display: block;
    }
    .frame-2{
        background: red;
    }
    .slide-nav{
        background: #000;
        height: 30px;
        position: fixed;
        width: 100%;
        z-index: 11005;
    }
    .slide-nav a{
        color: #fff;
        display: block;
        height: 30px;
        line-height: 30px;
        position: absolute;
        top: 0;
        width: 50%;
    }
    .slide-nav a:hover{
        background: #999;
    }
    .slide-nav .cycle-prev{
        left: 0;
    }
    .slide-nav .cycle-next{
        right: 0;
        text-align: right;
    }
</style>

<div class="content-wrapper">
    <div class="slide-nav">
        <a href="#" class="cycle-prev">Previous</a>
        <a href="#" class="cycle-next">Next</a>
    </div>
    <div class="cycle-slideshow"
         data-cycle-fx=scrollHorz
         data-cycle-timeout=0
         data-cycle-slides="> div"
         data-cycle-swipe=true
         >
        <div class="content-frame frame-1">
            <ul>
                <li style="margin-bottom: 20px">To do:</li>
                <li><del>Find new office</del></li>
                <li><del>Scratch head</del></li>
                <li><del>Stroke chin</del></li>
                <li><del>Drum fingers on table</del></li>
                <li><del>Sign contracts</del></li>
                <li><del>Scratch head again</del></li>
                <li><del>Pick moving date</del></li>
                <li><del>Make seating plan</del></li>
                <li><del>Redo seating plan</del></li>
                <li><del>Redo seating plan</del></li>
                <li><del>Redo seating plan</del></li>
                <li><del>Stop asking for feedback on seating plan</del></li>
                <li><del>Postpone move</del></li>
                <li><del>Make sure Dave is away on new moving date</del></li>
                <li><del>Spend several hundred hours on hold to British Telecom</del></li>
                <li><del>Redo stationery</del></li>
                <li><del>Start packing studio</del></li>
                <li><del>Contemplate how much junk we’ve hoarded in 4 years</del></li>
                <li><del>Pack kitchen</del></li>
                <li><del>Remove teabag from boiling water with bare hands</del></li>
                <li><del>Administer Savlon (other antiseptics are available)</del></li>
                <li><del>Unpack teaspoons</del></li>
                <li><del>Finish packing</del></li>
                <li><del>Say things like ‘we’ll really miss this place’</del></li>
                <li><del>Pull down shutters for the last time</del></li>
                <li><del>Leave small piece of cheese for office mouse</del></li>
                <li><del>Turn off lights</del></li>
                <li><del>Stop off at local pub to say goodbye to friendly landlord</del></li>
                <li><del>Drive to end of the street</del></li>
                <li><del>Turn right, then left, and left.</del></li>
                <li><del>Turn right onto Lever Street</del></li>
                <li><del>Ignore one-way signs</del></li>
                <li><del>Park up outside 24 Lever Street</del></li>
                <li><del>Unpack</del></li>
                <li><del>Enjoy ridiculously fast broadband for a change</del></li>
                <li><del>Apologise to anyone we haven’t told we’re moving.</del></li>
                <li>Invite people to ‘drop by for a cuppa’.</li>
            </ul>
        </div>
        <div class="content-frame frame-2">
                <video loop="loop" width="100%" autoplay="autoplay" poster="assets/video-poster.gif">
                  <source src="assets/fishtank.webm" type='video/webm; codecs="vp8, vorbis"' />
                  <source src="assets/fishtank.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
                  <source src="assets/fishtank.theora.ogv" type='video/ogg; codecs="theora, vorbis"' />
                  <img src="assets/video-poster.jpg" />
                <video>
        </div>
        <div class="content-frame frame-2">
            <h1>Content frame 2</h1>
        </div>
    </div>
</div>
