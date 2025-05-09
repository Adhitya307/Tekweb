<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Project - <?= esc($project['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .role-badge {
            font-size: 0.8rem;
            padding: 2px 8px;
            border-radius: 12px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Judul -->
    <div class="mb-4">
        <h2 class="display-6">📁 Project: <strong><?= esc($project['name']) ?></strong></h2>
        <p class="text-muted">Detail project dan daftar anggota tim.</p>
    </div>

    <!-- Undang Anggota -->
    <?php if ($isKetua): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Undang Anggota Baru</div>
            <div class="card-body">
                <form action="/projects/invite" method="post" class="row g-3">
                    <input type="hidden" name="project_id" value="<?= esc($project['id']) ?>">
                    <div class="col-md-9">
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email anggota..." required>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-success">Undang</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- Anggota -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">👥 Daftar Anggota Project</h5>
        </div>
        <div class="card-body">
            <?php if (empty($members)): ?>
                <p class="text-muted">Belum ada anggota dalam project ini.</p>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($members as $member): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= esc($member['nama']) ?>
                            <span class="badge bg-<?= $member['role'] === 'ketua' ? 'primary' : 'secondary' ?> role-badge">
                                <?= ucfirst($member['role']) ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- Kembali -->
    <div class="mt-4">
        <a href="/dashboard" class="btn btn-outline-secondary">← Kembali ke Dashboard</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal Kirim Undangan -->
<div class="modal fade" id="modalUndangEmail" tabindex="-1" aria-labelledby="modalUndangEmailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/kirim-undangan" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUndangEmailLabel">Kirim Undangan Mendaftar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="email" name="email" class="form-control" id="undanganEmailInput" required>
        <small class="text-muted">Sistem akan mengirim link pendaftaran ke email tersebut.</small>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Kirim Undangan</button>
      </div>
    </form>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (session()->getFlashdata('undangan_email')): ?>
            const modalElement = document.getElementById('modalUndangEmail');
            const modal = new bootstrap.Modal(modalElement);
            document.getElementById('undanganEmailInput').value = "<?= session()->getFlashdata('undangan_email') ?>";
            modal.show();
        <?php endif; ?>
    });
</script>

</body>
</html>
