<style>
    .profile, .wrapper, .bottom-nav{
        display: none !important;
    }
    #permissionMessage{
        color: grey;
    }
</style>
<div style="text-align: center;">
    <img src="<?= base_url('assets/images/permission-camera.png') ?>" alt="">
    <h1 style="font-weight: 900;color:#3BA5FA;margin-bottom:10px">Akses Kamera ditolak :(</h1>
    <div id="permissionMessage">
        <p>Akses kamera ditolak. Untuk mengaktifkan kembali, ikuti petunjuk di bawah ini:</p><br/>
        <ol style="text-align: left;margin:0 1em">
            <li>1. Buka pengaturan situs di browser Anda.</li>
            <li>2. Cari izin kamera untuk situs ini.</li>
            <li>3. Reset atau izinkan akses kamera.</li>
            <li>4. Refresh halaman ini.</li>
        </ol>
    </div><br/>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Refres Halaman</a>
</div>