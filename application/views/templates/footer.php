    </main>

    <!-- bottom navigation start -->
    <footer class="bottom-nav">
        <ul class="d-flex align-items-center justify-content-around w-100 h-100">
            <li>
                <a href="<?= base_url('dashboard') ?>" class="bottom-nav-link">
                    <img src="<?= base_url('') ?>assets/svg/bottom-nav/home.svg" alt="home" class="bottom-nav-icon" id="bottom-nav-home">
                    <span class="bottom-nav-title">Home</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('absen') ?>" class="bottom-nav-link">
                    <img src="<?= base_url('') ?>assets/svg/bottom-nav/ticket.svg" alt="absen" class="bottom-nav-icon" id="bottom-nav-home">
                    <span class="bottom-nav-title">Absen</span>
                </a>

            </li>
            <li>
                <a href="<?= base_url('history') ?>" class="bottom-nav-link">
                    <img src="<?= base_url('') ?>assets/svg/bottom-nav/category.svg" alt="history" class="bottom-nav-icon" id="bottom-nav-home">
                    <span class="bottom-nav-title">Riwayat</span>
                </a>
            </li>

        </ul>
    </footer>
    <!-- bottom navigation end -->

    <input type="hidden" name="base-url" value="<?= base_url() ?>">

    <!-- jquery -->
    <script src="<?= base_url('') ?>assets/js/jquery-3.6.1.min.js"></script>

    <!-- bootstrap -->
    <script src="<?= base_url('') ?>assets/js/bootstrap.bundle.min.js"></script>

    <!-- jquery ui -->
    <script src="<?= base_url('') ?>assets/js/jquery-ui.js"></script>

    <!-- mixitup -->
    <script src="<?= base_url('') ?>assets/js/mixitup.min.js"></script>

    <!-- gasp -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/gsap.min.js"></script>

    <!-- draggable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/Draggable.min.js"></script>

    <!-- swiper -->
    <script src="<?= base_url('') ?>assets/js/swiper-bundle.min.js"></script>

    <!-- datepicker -->
    <script src="<?= base_url('') ?>assets/js/jquery.datetimepicker.full.js"></script>

    <!-- script -->
    <script src="<?= base_url('') ?>assets/js/script.js?time=<?= time() ?>"></script>

    <script src="<?= base_url('') ?>assets/js/bottom-nav.js"></script>

    <?php
    if (count($js) > 0) {
        for ($i = 0; $i < count($js); $i++) {
            echo '<script src="' . $js[$i] . '"></script>';
        }
    }
    ?>

<script>
    const base_url = $('input[name="base-url"]').val();
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

        function successCallback(position) {
            // Dapatkan data lokasi dari position.coords
            console.log('Latitude: ' + position.coords.latitude +
                        ' Longitude: ' + position.coords.longitude);
        }

        function errorCallback(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("Akses lokasi ditolak oleh pengguna.");
                    // Redirect ke base_url/permission
                    window.location.href = base_url + "permission";
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Informasi lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    console.log("Waktu permintaan lokasi habis.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("Terjadi kesalahan tidak diketahui.");
                    break;
            }
        }
    </script>
    </body>

    </html>