//---------------Back to top----------------------
var animating = false;
$(window).scroll(function() {
    var divTop = Number($('#slide').css('top').replace('px', ''));

    if ($(this).scrollTop() >= 100 && !animating && divTop > 100) {
        // On scroll show block 'Welcome'
        animating = true;
        $("#slide").animate({ "top": 100 + "px" }, 1000, function() {
            animating = false;
        });
        return false;
    } else if ($(this).scrollTop() == 0 && !animating && divTop < 480) {
        // On scroll to top hide block 'Welcome'
        console.log('0');
        animating = true;
        $("#slide").animate({ "top": 480 + "px" }, 500, function() {
            animating = false;
        });
        return false;
    }
});