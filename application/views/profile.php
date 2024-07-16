<div class="container mt-4">
    <h2>Profil Pengguna</h2>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="<?= $profile->full_name ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">NISN</label>
                <input type="text" class="form-control" value="<?= $profile->nisn ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="<?= $profile->class_name ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Update PIN Form -->
            <div class="card">
                <form id="updatePinForm" method="post" action="<?= base_url('profile/update_pin') ?>">
                    <div class="card-body">
                        <h5 class="card-title">Update PIN</h5>
                        <?php if ($this->session->flashdata('success')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Ganti PIN (6 digits)</label>
                            <input type="password" name="new_pin" id="new_pin" class="form-control" minlength="6" maxlength="6" required>
                            <?= form_error('new_pin', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Update PIN</button>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <a href="<?= base_url('auth/logout') ?>" class="btn btn-primary mt-3">Keluar</a>
        </div>
    </div>
</div>