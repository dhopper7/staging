/**
 *
 * Ñontent slider with jCarousel
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

// Set active slide function
function setActiveSlide(i) {

    // Update current position counter
    $('#count').html( (i + 1) + '/' + $('.sl-slide').length );

    // Remove 'selected' class attribute from all jcarousel-items
    $('ul li').removeClass('selected');

    // Set 'selected' class attribute to a selected jcarousel-item
    var li = $('ul li').eq(i);
    li.addClass('selected');

    // Hide all slides (remove 'visible' class attribute)
    $('.sl-slide').removeClass('visible');

    // Show selected slide (set 'visible' class attribute)
    $('.sl-slide').eq(i).addClass('visible');

    // Update browser's URL with a title of selected slide (optional):
    window.location.hash = $('.visible .sl-title').text().replace(/ /g, '-');
}


// Once DOM (document) is finished loading
$(document).ready(function(){

    // View all mode
    var bViewAllMode = false;


    // Initialize jCarousel
    $('#sl-thumbs').jcarousel( {
		visible: 2,
		scroll: 1,
	});

    // set first active slide
    setActiveSlide(0);

    // jcarousel-item onclick handler
    $('#sl-thumbs li').click(function() {
        setActiveSlide($(this).index());
    });

    // Slide's image onclick handler
    $('.sl-slide img').click(function(){

        if (! bViewAllMode) {
            // Find current index and next position
            var iCur = $('ul li.selected').index();
            var iMax = $('ul li').length - 1;
            var iNext = (iCur + 1 >  iMax) ? 0 : (iCur + 1);

            // Update position and set to next slide
            setActiveSlide(iNext);
        }

        return false;
    });

    // Next button onclick handler
    $('.next').click(function(){

        // Find current index and next position
        var iCur = $('ul li.selected').index();
        var iMax = $('ul li').length - 1;
        var iNext = (iCur + 1) >  iMax ? 0 : (iCur + 1);

        // Update position and set to next slide
        setActiveSlide(iNext);

        return false;
    });

    // Prev button onclick handler
    $('.prev').click(function(){

        // Find current index and previous position
        var iCur = $('ul li.selected').index();
        var iMax = $('ul li').length - 1;
        var iPrev = (iCur - 1 >  iMax) ? 0 : (iCur - 1);
        iPrev = (iPrev == -1) ? iMax : iPrev;

        // Update position and set to previous slide
        setActiveSlide(iPrev);

        // Update browser's URL with a title of selected slide (optional):
        window.location.hash = $('.visible .sl-title').text().replace(/ /g, '-');

        return false;
    });

    // 'ViewAll' button onclick handler
    $('.sl-view-all').click(function() {

        // Set ViewAllMode to 'true' value
        bViewAllMode = true;

        // Hide controls, ViewAll button and jcarousel container
        $('.sl-controls, .sl-view-all, .jcarousel-container').hide();

        // Show Intro and all slides
        $('.sl-intro').show();
        $('.sl-slide').addClass('visible');
    });

    // 'Start' button onclick handler
    $('.sl-start').click(function () {

        // Set ViewAllMode to 'false' value
        bViewAllMode = false;

        // Hide Intro
        $('.sl-intro').hide();

        // Show controls, main slider section, ViewAll button and jcarousel container
        $('.sl-controls, .sl-main, .sl-view-all, .jcarousel-container').show();

        // set first active slide
        setActiveSlide(0);

        return false;
    });

    // 'BackHome' button onclick handler
    $('.back-home').click(function () {

        // Hide main slider section
        $('.sl-main').hide();

        // Show Intro
        $('.sl-intro').show();

        return false;
    });
});