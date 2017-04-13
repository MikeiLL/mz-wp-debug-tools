jQuery(document).ready(function( $ ) {
    var $container = $('#caregivers');

    // create a clone that will be used for measuring container width
    $containerProxy = $container.clone().empty().css({ visibility: 'hidden' });   
 
    $container.after( $containerProxy );  
 
    // get the first item to use for measuring columnWidth
    var $item = $container.find('.caregiver-item').eq(0);

    $container.imagesLoaded(function(){
        $(window).smartresize( function() {
 
            // calculate columnWidth
            var colWidth = Math.floor( $containerProxy.width() / 3 ); // Change this number to your desired amount of columns
 
            // set width of container based on columnWidth
            $container.css({
                width: colWidth * 3 // Change this number to your desired amount of columns
            })
            .isotope({
 
                // disable automatic resizing when window is resized
                resizable: false,
 
                // set columnWidth option for masonry
                masonry: {
                    columnWidth: colWidth
                }
            });
 
        // trigger smartresize for first time
        }).smartresize();
    });
 
    // filter items when filter link is clicked
    $('#filters a').click(function(){
        var selector = $(this).attr('data-filter');
        $container.isotope({ filter: selector, animationEngine : "css" });
        $('#filters a.active').removeClass('active');
        $(this).addClass('active');
        return false;
 
    });
 
});