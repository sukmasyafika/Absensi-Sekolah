<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('user'); ?>" class="text-decoration-none">pengguna</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>

    <h1 class="h3 mb-3 text-primary fw-bold"><?= $title; ?></h1>


    <div class="row">
        <div class="col-md-6">

            <div class="card shadow-lg">
                <div class="card-body">

                    <form action="<?= base_url('user/update/' . $pengguna->userid); ?>" method="POST">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="id_guru" class="form-label">Nama Guru</label>
                            <select name="id_guru" id="id_guru" class="form-control <?= (session('errors.id_guru')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Guru --</option>
                                <?php foreach ($guruList as $guru): ?>
                                    <option value="<?= $guru->id; ?>" <?= ($guru->id == old('id_guru', $pengguna->id_guru ?? '')) ? 'selected' : ''; ?>>
                                        <?= esc($guru->nama); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= session('errors.id_guru'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username"
                                class="form-control <?= (session('errors.username')) ? 'is-invalid' : ''; ?>"
                                value="<?= old('username', $pengguna->username ?? ''); ?>" placeholder="Masukkan username">
                            <div class="invalid-feedback"><?= session('errors.username'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control <?= (session('errors.email')) ? 'is-invalid' : ''; ?>"
                                value="<?= old('email', $pengguna->email ?? ''); ?>" placeholder="Masukkan email">
                            <div class="invalid-feedback"><?= session('errors.email'); ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role"
                                class="form-control <?= (session('errors.role')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= old('role', $pengguna->group_name ?? '') == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="guru" <?= old('role', $pengguna->group_name ?? '') == 'guru' ? 'selected' : ''; ?>>Guru</option>
                                <option value="kajur" <?= old('role', $pengguna->group_name ?? '') == 'kajur' ? 'selected' : ''; ?>>Kajur</option>
                                <option value="wali kelas" <?= old('role', $pengguna->group_name ?? '') == 'wali kelas' ? 'selected' : ''; ?>>Wali Kelas</option>
                            </select>
                            <div class="invalid-feedback"><?= session('errors.role'); ?></div>
                        </div>

                        <div class="text-start mt-3">
                            <a href="<?= base_url('/user'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>