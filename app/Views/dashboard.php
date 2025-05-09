<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - TaskTim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-project {
            transition: transform 0.2s;
        }
        .card-project:hover {
            transform: scale(1.03);
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-light">

<?= view('partials/navbar'); ?>

<!-- Konten -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">📁 Project Saya</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            + Buat Project
        </button>
    </div>

    <?php if (empty($projects)): ?>
        <div class="alert alert-info">Belum ada project. Silakan buat project baru.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($projects as $project): ?>
                <div class="col">
                    <div class="card card-project h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><?= esc($project['name']) ?></h5>
                        </div>
                        <div class="card-footer bg-white d-grid gap-2">
                            <a href="/projects/<?= $project['id'] ?>/members" class="btn btn-outline-primary">👥 Lihat Anggota</a>
                            <a href="<?= base_url('project/' . $project['id']) ?>" class="btn btn-outline-secondary">🔍 Lihat Detail</a>
                            <?php if (isset($project['role']) && $project['role'] === 'ketua'): ?>

                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editProjectModal<?= $project['id'] ?>">✏️ Edit</button>
                                <form action="/projects/delete" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="d-grid">
                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger">🗑️ Hapus</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Project (hanya untuk Ketua) -->
                <?php if (isset($project['role']) && $project['role'] === 'ketua'): ?>

                <div class="modal fade" id="editProjectModal<?= $project['id'] ?>" tabindex="-1" aria-labelledby="editProjectModalLabel<?= $project['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="/projects/update" method="post" class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editProjectModalLabel<?= $project['id'] ?>">Edit Nama Proyek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $project['id'] ?>">
                          <div class="mb-3">
                              <label for="projectName<?= $project['id'] ?>" class="form-label">Nama Proyek</label>
                              <input type="text" class="form-control" id="projectName<?= $project['id'] ?>" name="name" value="<?= esc($project['name']) ?>" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Create Project -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/projects/create" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createProjectModalLabel">Buat Project Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <label for="projectName" class="form-label">Nama Project</label>
              <input type="text" class="form-control" id="projectName" name="name" required placeholder="Masukkan nama project">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Buat Project</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Flash Message -->
<?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
<div class="modal fade" id="flashMessageModal" tabindex="-1" aria-labelledby="flashMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content <?= session()->getFlashdata('success') ? 'border-success' : 'border-danger' ?>">
      <div class="modal-body text-center p-5">
        <?php if (session()->getFlashdata('success')): ?>
          <div class="mb-3">
              <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Success" width="80">
          </div>
          <h5 class="text-success">✅ <?= session()->getFlashdata('success') ?></h5>
        <?php elseif (session()->getFlashdata('error')): ?>
          <div class="mb-3">
              <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="Error" width="80">
          </div>
          <h5 class="text-danger">❌ <?= session()->getFlashdata('error') ?></h5>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var flashModal = document.getElementById('flashMessageModal');
    if (flashModal) {
      var modal = new bootstrap.Modal(flashModal);
      modal.show();

      setTimeout(() => {
        modal.hide();
      }, 3000);
    }
  });
</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>