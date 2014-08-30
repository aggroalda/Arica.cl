// JavaScript Document

//When Everything is loaded */
$(document).ready(function() {

//Setup all the slides.
$('#slideShowItems div').hide().css({position:'absolute',width:'700px'});

var currentSlide = -1; //keeps track of current slide
var prevSlide = null; //keeps track of last selected slide.
var slides = $('#slideShowItems div'); // all the slides
var interval = null; //For setInerval
var FADE_SPEED = 500;  //How long it takes to transition.
var DELAY_SPEED = 15000; //How long each slide stays up.

var html = '<ul id="slideShowCount">';  //Creates a ul list for tabs

//Create a tab for each slide.
for (var i = slides.length - 1;i >= 0 ; i--){
    html += '<li id="slide'+ i+'" class="slide">'+(i+1)+'</li>' ;
}
html += '</ul>';

/*
html =

<ul id="slideShowCount">
<li id="slide0" class="slide"><span>1</span></li>
<li id="slide1" class="slide"><span>2</span></li>

</ul>

*/

//Put tabs after slideshow warpper.
$('#slideShow').after(html);


//Set the click event for each tab.
for (var i = slides.length - 1;i >= 0 ; i--){
   
    $('#slide'+i).bind("click",{index:i},function(event){
       
        //Sets the current slide to the one clicked.
        currentSlide = event.data.index;
       
        //Go to the slide.
        gotoSlide(event.data.index);
    });
   
};


//If there is 1 or less slides then hide the tabs.
if (slides.length <= 1){
    $('.slide').hide();
}


//get things started.
nextSlide();


//Goes to the next slide.
function nextSlide (){

    //if the current slide is at the end, loop to the first slide.
    if (currentSlide >= slides.length -1){
        currentSlide = 0;
    }else{
        currentSlide++
    }
   
    //Go to the slide.
    gotoSlide(currentSlide);

}


//Go to the slide specified in the argument.
function gotoSlide(slideNum){

    //If the slide they're trying to access isn't
    //the currently selected slide...
    if (slideNum != prevSlide){

        //The very first slide the prevSlide will be null.
        //No point in trying to hide the slide when it doesn't
        //exist yet.
        if (prevSlide != null){
           
            //Hide previoius slide and deselect old tab.
            $(slides[prevSlide]).stop().hide();
            $('#slide'+prevSlide).removeClass('selectedTab');
        }
       
       
        //Select new tab.
        $('#slide'+slideNum).addClass('selectedTab');

        //Display new slide.
        $(slides[slideNum]).stop().slideDown(FADE_SPEED);
       
        //Make the currentSlide the old slide for next transition.
        prevSlide = currentSlide;

        //if the auto slide advance is set, stop it, then start again.
        if (interval != null){
            clearInterval(interval);
        }
       
        //Goes to next slide every couple of seconds.
        interval = setInterval(nextSlide, DELAY_SPEED);
    }

}
});