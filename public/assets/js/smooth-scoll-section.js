var animating = false;
$(document).ready(function() {
    var scrollLink = $('.scroll');
    // Smooth scrolling
    scrollLink.click(function(e) {
        //e.preventDefault();
        animating = true;

        $('body,html').animate({

            scrollTop: $(this.hash).offset().top - 90
        }, 100);
    });

    // Active link switching
    $(window).scroll(function() {
        var scrollbarLocation = $(this).scrollTop();
        scrollLink.each(function() {
            var sectionOffset = $(this.hash).offset().top - 90;
            if (sectionOffset <= scrollbarLocation) {
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
            }
        })
    })
});