<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travgo</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('') ?>assets/images/favicon.png" type="image/x-icon">

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

    <!-- home -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/home.css">

    <!-- style -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/style.css">
</head>

<body class="scrollbar-hidden">
    <!-- splash-screen start -->
    <section id="preloader" class="spalsh-screen">
        <div class="circle text-center">
            <div>
                <h1>Sesaca</h1>
                <p>Aplikasi Absensi SMPN 1 California</p>
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

    <main class="home">
        <!-- menu, side-menu start -->
        <section class="wrapper dz-mode">
            <!-- menu -->
            <div class="menu d-flex justify-content-end">
                <div class="btn-grp d-flex align-items-center gap-16">
                    <label for="mode-change" class="mode-change d-flex align-items-center justify-content-center">
                        <input type="checkbox" id="mode-change">
                        <img src="<?= base_url('') ?>assets/svg/menu/sun-white.svg" alt="icon" class="sun">
                        <img src="<?= base_url('') ?>assets/svg/menu/moon-white.svg" alt="icon" class="moon">
                    </label>
                    <a href="<?= base_url('profile') ?>">
                        <img src="<?= base_url('') ?>assets/svg/menu/profile-white.svg" alt="icon">
                    </a>
                </div>
            </div>

        </section>
        <!-- menu, side-menu end -->

        <!-- info start -->
        <section class="info d-flex align-items-start justify-content-between pb-12">
            <div class="d-flex align-items-center justify-content-between gap-14">
                <div class="image shrink-0 rounded-full overflow-hidden">
                    <img src="<?= base_url('') ?>assets/images/home/avatar.png" alt="avatar" class="w-100 h-100 object-fit-cover">
                </div>
                <div>
                    <h3>Hai, Andy</h3>
                    <p class="d-flex align-items-center gap-04">
                        Netherlands
                    </p>
                </div>
            </div>
        </section>
        <!-- info end -->
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
                    <span class="bottom-nav-title">History</span>
                </a>
            </li>

        </ul>
    </footer>
    <!-- bottom navigation end -->

    <!-- jquery -->
    <script src="<?= base_url('') ?>assets/js/jquery-3.6.1.min.js"></script>

    <!-- bootstrap -->
    <script src="<?= base_url('') ?>assets/js/bootstrap.bundle.min.js"></script>

    <!-- jquery ui -->
    <script src="<?= base_url('') ?>assets/js/jquery-ui.js"></script>

    <!-- mixitup -->
    <script src="<?= base_url('') ?>assets/js/mixitup.min.js"></script>

    <!-- script -->
    <script src="<?= base_url('') ?>assets/js/script.js"></script>

    <script src="<?= base_url('') ?>assets/js/bottom-nav.js"></script>
</body>

</html>