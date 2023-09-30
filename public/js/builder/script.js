window.addEventListener('load', setHeight);

// Panggil fungsi setHeight saat jendela berubah ukuran
window.addEventListener('resize', setHeight);


// membuat tinggi content dinamis
function setHeight() {
    var navbarHeight = $('.navbar-builder').outerHeight();
    var windowHeight = $(window).height();
    var content = $('.wrapper-editor');

    // Hitung tinggi content
    var contentHeight = windowHeight - navbarHeight;

    // Set tinggi content
    content.css('height', contentHeight + 'px');
}


