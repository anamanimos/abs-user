<style>
    .profile{
        display: none !important;
    }
    .header-cover{
        position: absolute;
        left: 0;
        margin-top: -18px;
        width: 100%;
    }
</style>

<?php if ($today_absence_done == false) {
?>
<input type="hidden" name="allow" value="true">
<div class="row">
    <div class="col-12">
        <img src="<?= base_url('assets/images/izin-sakit.png') ?>" alt="" class="header-cover">
        <div class="absence-radio-container mb-4">
            <input type="radio" id="izin" name="status" value="2" checked>
            <label for="izin">
                <i class="bi bi-person-check"></i>
                <span>Izin</span>
            </label>
            <input type="radio" id="sakit" name="status" value="3">
            <label for="sakit">
                <i class="bi bi-hospital"></i>
                <span>Sakit</span>
            </label>
        </div>

        <span class="title">Unggah File Pendukung</span>
        <div class="absence-upload-container mt-2 mb-4">
            <i class="bi bi-cloud-arrow-up"></i>
            <p>Format file yang diperbolehkan jpg, png, pdf. Ukuran file Maksimal 1MB</p>
            <button onclick="document.getElementById('fileInput').click();" class="btn btn-cover btn-rounded btn-primary">Pilih File</button>
            <input type="file" id="fileInput" accept=".jpg,.png,.pdf">
        </div>
        <div class="absence-file-card mt-2 mb-4" style="display: none;">
            <div class="file-details">
                <div class="file-icon">PDF</div>
                <div>
                    <div class="file-name">dummy-filename.pdf</div>
                    <div class="file-size">Size: 2 MB</div>
                </div>
            </div>
            <button onclick="document.getElementById('fileInput').click();" class="btn btn-rounded btn-cover btn-primary">Ganti File</button>
        </div>

        <span class="title">Tambahkan Keterangan</span>
        <textarea name="reason" id="" class="absence-textarea mt-2" rows="4"></textarea>

        <button class="btn btn-primary btn-sm mt-5" id="saveAbsence">Absen Sekarang</button>
    </div>
</div>

<?php

    } else{
?>  <input type="hidden" name="allow" value="false">
    <div class="row text-center" id="row-check">
        <div class="col-12">
            <img src="<?= base_url('assets/images/attendence-check.png') ?>" alt="">
            <div id="disableAbsence">
                <h3 class="title">Absensi Sukses</h3>
                <span style="color:grey;font-size:0.9em">Terima kasih, kamu telah melakukan absensi hari ini.</span>
            </div>
            <a href="<?= base_url('absen') ?>" class="btn btn-info btn-cover btn-rounded mt-3">Kembali</a>
        </div>
    </div>
<?php } ?>