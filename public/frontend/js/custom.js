$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    var box = $(".hero-slides").height() - 20;
    var header = $(".navbar").height();

    if (scroll >= box - header) {
        $(".navbar").addClass("fixed-top");
    } else {
        $(".navbar").removeClass("fixed-top");
    }
});
