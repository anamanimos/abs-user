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
    <h1 style="font-weight: 900;color:#3BA5FA;margin-bottom:10px">Terlalu jauh :(</h1>
    <div id="permissionMessage">
        <p>Kamu terlalu jauh dari sekolah, untuk melakukan absensi kamu harus berada di area sekolah.</p>
    </div><br/>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Refres Halaman</a>
</div>