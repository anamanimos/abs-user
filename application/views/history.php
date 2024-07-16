<style>
    .profile{
        display: none !important;
    }
</style>
<div class="container">
    <div class="row mt-2">
        <div class="col-12">
            <div id="history-filter">
                <?= bulan_indonesia(sprintf('%02d', $selected_month)) ?>, <?= $selected_year ?> <i class="bi bi-funnel-fill"></i>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="last-activity">
            <?php
            // Menghitung jumlah hari dalam bulan dan tahun tertentu
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);

            // Loop untuk menampilkan tanggal 1 hingga selesai
            for ($day = 1; $day <= $days_in_month; $day++) :
                // Cari data absensi untuk tanggal saat ini
                $found = false;
                foreach ($absence_history as $absence) {
                    $absence_date = date('d', strtotime($absence['absence_date']));
                    if ((int)$absence_date === $day) {
                        $found = true;
            ?>
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
                    <?php
                    }
                }
                // Jika tidak ditemukan, tampilkan baris tabel dengan teks "Belum Absen"
                if (!$found) {
                    ?>
                <div class="last-activity-item">
                    <div class="last-activity-item-top">
                        <span class="last-activity-item-date"><i class="bi bi-calendar2-week me-1"></i> <?php echo tanggal_indonesia($selected_year.'-'.$selected_month.'-'.$day); ?></span>
                        <span class="last-activity-item-time"><i class="bi bi-clock-history me-1"></i> ∞ WIB</span>
                    </div>
                    <div class="last-activity-item-main">
                        <h3 class="text-secondary">Tidak Absen</h3>
                    </div>
                    <div class="last-activity-item-bottom">
                    </div>
                </div>
            <?php
                }
            endfor;
            ?>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Pilih Bulan dan Tahun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="get" action="<?= base_url('history') ?>" class="row mb-3">
                    <div class="row mb-3">
                        <label for="month" class="col-sm-3 col-form-label">Bulan:</label>
                        <div class="col-sm-9">
                            <select name="month" id="month" class="form-control">
                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                    <option value="<?= sprintf('%02d', $m) ?>" <?= isset($selected_month) && $selected_month == sprintf('%02d', $m) ? 'selected' : '' ?>>
                                        <?= bulan_indonesia(sprintf('%02d', date('m', mktime(0, 0, 0, $m, 1)))) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="year" class="col-sm-3 col-form-label">Tahun:</label>
                        <div class="col-sm-9">
                            <select name="year" id="year" class="form-control">
                                <?php for ($y = date('Y') - 1; $y <= date('Y'); $y++) : ?>
                                    <option value="<?= $y ?>" <?= isset($selected_year) && $selected_year == $y ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>