<?php if ($today_absence_done == false) { ?>
    <div class="card-home radius-8 align-items-center mb-3">
        <div class="card-body">
            <img src="<?= base_url('assets/images/oc-unlock.svg') ?>" alt="" class="mb-5 mt-5" id="iconAbsen">
            <img id="photoPreview" class="photo-preview" style="display: none;">
            <video id="videoElement" class="photo-preview" playsinline style="display: none;"></video>
        </div>
        <!-- card-footer -->
        <div class="card-footer d-flex align-items-center justify-content-between" id="cardFooterAbsen">
            <button class="btn btn-primary btn-sm mt-3" id="openCameraBtn">Buka Kamera</button>
            <div class="action-btns" style="display: none;">
                <button class="btn btn-primary btn-sm mt-3" id="retakePhotoBtn">Ambil Gambar Ulang</button>
                <button class="btn btn-primary btn-sm mt-3" id="sendAbsenceBtn">Kirim Absen</button>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="card-home radius-8 align-items-center mb-3">
        <div class="card-body">
            <h3 class="card-title mt-3 mb-5">Terima kasih, <br />Kamu Sudah Absen Hari ini :)</h3>
            <img src="<?= base_url('assets/images/oc-unlock.svg') ?>" alt="" class="mb-5">
        </div>
    </div>
<?php } ?>