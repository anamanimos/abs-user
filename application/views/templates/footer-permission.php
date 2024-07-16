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
    <script src="<?= base_url('') ?>assets/js/script.js"></script>

    <script src="<?= base_url('') ?>assets/js/bottom-nav.js"></script>

    <?php
    if (count($js) > 0) {
        for ($i = 0; $i < count($js); $i++) {
            echo '<script src="' . $js[$i] . '"></script>';
        }
    }
    ?>
    </body>

    </html>