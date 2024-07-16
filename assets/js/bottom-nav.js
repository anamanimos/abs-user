document.addEventListener('DOMContentLoaded', function () {
    // Ambil URL saat ini tanpa domain dan base_url
    var currentUrl = window.location.href;

    // Daftar link dalam bottom-nav
    var bottomNavLinks = document.querySelectorAll('.bottom-nav-link');

    // Iterasi setiap link untuk menentukan gambar aktif
    bottomNavLinks.forEach(function (link) {
        var href = link.getAttribute('href');
        var icon = link.querySelector('.bottom-nav-icon');

        // Jika href sama dengan currentUrl, ubah src gambar menjadi versi active
        if (href === currentUrl) {
            var originalSrc = icon.getAttribute('src');
            var activeSrc = originalSrc.replace('.svg', '-active.svg');
            icon.setAttribute('src', activeSrc);
        }
    });
});
