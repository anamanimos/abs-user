<div class="card-home mb-5">
    <div class="card-home-day"><?= tanggal_indonesia(date('Y-m-d'))?></div>
    <div class="card-home-time poppins-bold" id="clock">07.00</div>
    <a href="<?= base_url('absen') ?>" class="btn btn-primary btn-sm dashboard-btn-absence mb-3">Absen Sekarang</a>
</div>

<div class="row">
    <div class="col-12">
        <h4 class="title">Aktivitas Terbaru</h4>
        <div class="last-activity">
    <?php foreach ($last_absences as $absence): ?>
        <div class="last-activity-item">
            <div class="last-activity-item-top">
                <span class="last-activity-item-date"><i class="bi bi-calendar2-week me-1"></i> <?php echo tanggal_indonesia($absence['absence_date']); ?></span>
                <span class="last-activity-item-time"><i class="bi bi-clock-history me-1"></i> <?php echo $absence['absence_time']; ?> WIB</span>
            </div>
            <div class="last-activity-item-main">
                <?php
                    switch ($absence['status_code']) {
                        case 1:
                            echo '<h3 class="text-success">' . $absence['status'] . '</h3>';
                            break;
                        case 2:
                            echo '<h3 class="text-primary">' . $absence['status'] . '</h3>';
                            break;
                        case 3:
                            echo '<h3 class="text-warning">' . $absence['status'] . '</h3>';
                            break;
                        case 4:
                            echo '<h3 class="text-danger">' . $absence['status'] . '</h3>';
                            break;
                        default:
                            echo '<h3 class="text-secondary">' . $absence['status'] . '</h3>';
                            break;
                    }
                ?>
            </div>
            <div class="last-activity-item-bottom">
                <?php echo $absence['type']; ?>
                <?php echo $absence['session']; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <a href="<?= base_url('history') ?>" class="btn btn-rounded btn-cover btn-info btn-sm mb-3 mt-3">Lihat Riwayat Absen</a>
    </div>
</div>