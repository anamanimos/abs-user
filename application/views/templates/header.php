<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aplikasi Absensi SMPN 11 Madiun</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.webp') ?>" type="image/x-icon">

    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    

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


    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- welcome -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/welcome.css">

    <!-- home -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/home.css">

    <!-- style -->
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/style.css?<?= time() ?>">

    <!-- CSS Inject -->
    <?php
    if (count($css) > 0) {
        for ($i = 0; $i < count($css); $i++) {
            echo '<link rel="stylesheet" href="' . $css[$i] . '">';
        }
    }
    ?>
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

    <main class="home">
        <!-- menu, side-menu start -->
        <section class="wrapper dz-mode">
            <!-- menu -->
            <div class="menu d-flex justify-content-between align-items-center">
                <div class="pages-title">
                    <h5><?= $title ?></h5>
                </div>
                <div class="btn-grp d-flex align-items-center gap-16">
                    <a href="<?= base_url('profile') ?>">
                        <img src="<?= base_url('') ?>assets/svg/menu/profile-white.svg" alt="icon">
                    </a>
                </div>
            </div>
        </section>
        <!-- menu, side-menu end -->

        <!-- info start -->
        <section class="info d-flex align-items-start justify-content-between pb-12 profile">
            <div class="d-flex align-items-center justify-content-between gap-14">
                <div class="image shrink-0 rounded-full overflow-hidden">
                    <img src="<?= base_url('') ?>assets/images/default.jpg" alt="avatar" class="w-100 h-100 object-fit-cover">
                </div>
                <div>
                    <h3>Hai, <?php echo $profile->full_name; ?></h3>
                    <p class="d-flex align-items-center gap-04">
                        <?php echo $profile->class_name; ?>
                    </p>
                </div>
            </div>
        </section>
        <!-- info end -->