<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk | Absensi SMPN 11 Kota Madiun</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.webp') ?>" type="image/x-icon">

    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/bootstrap.min.css">

    <!-- swiper -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/swiper-bundle.min.css">

    <!-- datepicker -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/jquery.datetimepicker.css">

    <!-- jquery ui -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/jquery-ui.min.css">

    <!-- common -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/common.css">

    <!-- animations -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/animations.css">

    <!-- welcome -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/welcome.css">

    <!-- auth -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/auth.css">
</head>

<body class="scrollbar-hidden">
    <!-- splash-screen start -->
    <section id="preloader" class="spalsh-screen">
        <div class="circle text-center">
            <div>
                <img src="<?= base_url('assets/images/logo.webp') ?>" alt="" style="width:80%">
            </div>
        </div>
        <div class="loader-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </section>
    <!-- splash-screen end -->

    <main class="auth-main">
        <!-- menu, side-menu start -->
        <section class="wrapper dz-mode">
            <!-- menu -->
            <div class="menu">
                <div class="btn-grp d-flex align-items-center gap-16">
                </div>
            </div>
        </section>
        <!-- menu, side-menu end -->

        <!-- signin start -->
        <section class="auth signin">
            <div class="heading">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="" style="width:60%" class="mb-5">
                <h2>Selamat Datang</h2>
                <p>Aplikasi Absensi SMPN 11 Kota Madiun</p>
            </div>

            <div class="form-area auth-form">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <?php echo form_open('auth/login'); ?>
                <div class="mb-3">
                    <label for="nisn">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" id="nisn" placeholder="NISN" class="input-field" name="nisn" value="<?php echo set_value('nisn', get_cookie('nisn')); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="pin">PIN</label>
                    <input type="password" id="pin" placeholder="******" class="input-field" name="pin" value="<?php echo set_value('pin', get_cookie('pin')); ?>" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">Tetap masuk</label>
                </div>
                <button type="submit" class="btn-primary">Masuk</button>
                <?php echo form_close(); ?>
            </div>
        </section>
        <!-- signin end -->
    </main>

    <!-- modal start -->
    <div class="modal fade loginSuccessModal modalBg" id="loginSuccess" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="<?= base_url('') ?>assets/svg/check-green.svg" alt="Check">
                    <h3>Berhasil Masuk!</h3>
                    <p class="mb-32">Kamu akan segera dialihkan ke halaman Dashboard</p>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->

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

    <!-- google-map api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCodvr4TmsTJdYPjs_5PWLPTNLA9uA4iq8&callback=initMap" type="text/javascript"></script>

    <!-- script -->
    <script src="<?= base_url('') ?>assets/js/script.js"></script>

    <script>
        $(document).ready(function() {
            // Handling form submission
            $('form').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Perform AJAX login request
                $.ajax({
                    url: $(this).attr('action'), // Get form action URL
                    type: $(this).attr('method'), // Get form method
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            // Login berhasil
                            $('#loginSuccess').modal('show'); // Tampilkan modal loginSuccessModal
                            setTimeout(function() {
                                window.location.href = '<?= base_url('dashboard') ?>'; // Redirect ke halaman dashboard setelah beberapa waktu
                            }, 3000); // Contoh: setelah 3 detik
                        } else {
                            // Jika login gagal, tampilkan pesan kesalahan
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.message
                            });
                        }
                    },
                    error: function() {
                        // Handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan. Silakan coba lagi.'
                        });
                    }
                });
            });

            // Code lainnya...
        });
    </script>
</body>

</html>