<style>
    .profile, .wrapper, .bottom-nav{
        display: none !important;
    }
    #permissionMessage{
        color: grey;
    }
</style>
<div style="text-align: center;">
    <img src="<?= base_url('assets/images/permission-location.png') ?>" alt="">
    <h1 style="font-weight: 900;color:#3BA5FA;margin-bottom:10px">Akses Lokasi ditolak :(</h1>
    <div id="permissionMessage">
        <p>Akses lokasi ditolak. Untuk mengaktifkan kembali, ikuti petunjuk di bawah ini:</p><br/>
        <ol style="text-align: left;margin:0 1em">
            <li>1. Buka pengaturan situs di browser Anda.</li>
            <li>2. Cari izin lokasi untuk situs ini.</li>
            <li>3. Reset atau izinkan akses lokasi.</li>
            <li>4. Klik tombol Refresh halaman.</li>
        </ol>
    </div><br/>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Refres Halaman</a>
</div>