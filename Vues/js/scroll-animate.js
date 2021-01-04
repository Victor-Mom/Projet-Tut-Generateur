$(document).ready(function() {
    $('body').on('click', '.navbar-nav a', function(e) {
        $('a.active').removeClass('active');
        var link = $(this);
        link.addClass('active');
        // Scroll animation
        $('html, body').animate( { scrollTop: $(link.attr('href')).offset().top - 57 }, 750 );
        return false;
    });

    //Scrollspy
    $('body').scrollspy({ target: '#menu' });
});
