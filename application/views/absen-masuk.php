<style>
    .profile{
        display: none !important;
    }
</style>
<?php
if ($today_absence_done == false) {
    
    if ($time_to_absence == true) {
        
?>
<input type="hidden" name="allow" value="true">
<input type="hidden" name="absence-camera" val="<?= get_setting('absence_camera') ?>"/>
    <div class="row text-center" id="row-opening">
        <div class="col-12">
            <img src="<?= base_url('assets/images/attendence.png') ?>" alt="">
            <div id="allowAbsence">
                <h3 class="title">Absensi Masuk</h3>
                <span style="color:grey;font-size:0.9em">Absensi masuk di buka pukul <?= jamAbsen($session['start'])?> dan berakhir pukul <?= jamAbsen($session['end'])?> WIB. Pastikan Kamu tidak terlambat Ya...!</span>
                <?php
                if(get_setting('absence_camera') === true){
                ?>
                    <button class="btn btn-primary btn-sm mt-3" id="openCameraBtn">Absen Sekarang</button>
                <?php
                }else{
                ?>
                    <button class="btn btn-primary btn-sm mt-3" id="absenceNoCamera">Absen Sekarang</button>
                <?php
                }
                ?>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img id="photoPreview" class="photo-preview" style="display: none;">
            <video id="videoElement" class="photo-preview" playsinline style="display: none;"></video>
            <div class="action-btns" style="display: none;">
                    <button class="btn btn-info btn-sm mt-3 btn-cover btn-rounded" id="retakePhotoBtn">Ambil Gambar Ulang</button>
                    <button class="btn btn-primary btn-sm mt-3" id="sendAbsenceBtn">Kirim Absen</button>
            </div>
            <div class="d-flex align-items-center justify-content-between" id="cardFooterAbsen">
                
            </div>
            <a href="<?= base_url('absen') ?>" class="btn btn-info btn-cover btn-rounded mt-3">Kembali</a>
        </div>
    </div>
<?php
    }else{?><input type="hidden" name="allow" value="false">
    <div class="row text-center" id="row-sad">
        <div class="col-12">
            <img src="<?= base_url('assets/images/attendence-sad.png') ?>" alt="">
            <div id="disableAbsence">
                <h3 class="title">Absensi Masuk Belum dibuka</h3>
                <span style="color:grey;font-size:0.9em">Kamu tidak dapat melakukan absen masuk. Absensi masuk di buka pukul <?= jamAbsen($session['start'])?> dan berakhir pukul <?= jamAbsen($session['end'])?> WIB.</span>
            </div>
            <a href="<?= base_url('absen') ?>" class="btn btn-info btn-cover btn-rounded mt-3">Kembali</a>
        </div>
    </div>
    <?php
    }
    } else{
?><input type="hidden" name="allow" value="false">
    <div class="row text-center" id="row-check">
        <div class="col-12">
            <img src="<?= base_url('assets/images/attendence-check.png') ?>" alt="">
            <div id="disableAbsence">
                <h3 class="title">Absensi Sukses</h3>
                <span style="color:grey;font-size:0.9em">Terima kasih, kamu telah melakukan absensi masuk hari ini. Jangan lupa lakukan Absensi Pulang saat jam pelajaran telah usai.</span>
            </div>
            <a href="<?= base_url('absen') ?>" class="btn btn-info btn-cover btn-rounded mt-3">Kembali</a>
        </div>
    </div>
<?php } ?>