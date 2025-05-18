<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - TaskTim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* Font elegan */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a3c4f3 0%, #ffffff 50%, #f8d7e0 100%);
            min-height: 100vh;
            color: #333;
        }
        /* Container lebih padat dan rapi */
        .container {
            max-width: 1200px;
        }
        /* Judul */
        h3.mb-0 {
            font-weight: 600;
            color: #2a3d66;
            text-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* Card project dengan shadow mewah */
        .card-project {
            border-radius: 12px;
            border: 1px solid rgba(42, 61, 102, 0.15);
            box-shadow: 0 8px 20px rgba(42, 61, 102, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffffcc; /* sedikit transparan agar lembut */
        }
        .card-project:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(42, 61, 102, 0.25);
            border-color: #5670d3;
        }
        .card-title {
            font-weight: 600;
            color: #2a3d66;
            letter-spacing: 0.03em;
        }
        /* Footer tombol */
        .card-footer {
            background: transparent;
            border-top: none;
            padding-top: 1rem;
        }
        .btn-outline-primary {
            border-color: #5670d3;
            color: #5670d3;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(86, 112, 211, 0.3);
            border-radius: 30px;
        }
        .btn-outline-primary:hover {
            background: #5670d3;
            color: #fff;
            box-shadow: 0 4px 14px rgba(86, 112, 211, 0.6);
        }
        .btn-outline-secondary {
            border-color: #9e9e9e;
            color: #6e6e6e;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(110, 110, 110, 0.2);
        }
        .btn-outline-secondary:hover {
            background: #6e6e6e;
            color: #fff;
            box-shadow: 0 4px 14px rgba(110, 110, 110, 0.5);
        }
        .btn-outline-warning {
            border-color: #f0ad4e;
            color: #f0ad4e;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 2px 6px rgba(240, 173, 78, 0.3);
            transition: all 0.3s ease;
        }
        .btn-outline-warning:hover {
            background: #f0ad4e;
            color: #fff;
            box-shadow: 0 4px 14px rgba(240, 173, 78, 0.6);
        }
        .btn-outline-danger {
            border-color: #d9534f;
            color: #d9534f;
            font-weight: 600;
            border-radius: 30px;
            box-shadow: 0 2px 6px rgba(217, 83, 79, 0.3);
            transition: all 0.3s ease;
        }
        .btn-outline-danger:hover {
            background: #d9534f;
            color: #fff;
            box-shadow: 0 4px 14px rgba(217, 83, 79, 0.6);
        }
        /* Modal styling */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(42, 61, 102, 0.25);
            border: none;
            font-weight: 500;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        .modal-title {
            color: #2a3d66;
            font-weight: 600;
            font-size: 1.4rem;
        }
        .btn-close {
            filter: brightness(0.7);
            transition: filter 0.2s ease;
        }
        .btn-close:hover {
            filter: brightness(1);
        }
        /* Input fokus */
        input.form-control:focus {
            border-color: #5670d3;
            box-shadow: 0 0 8px rgba(86, 112, 211, 0.4);
        }
        /* Alert info */
        .alert-info {
            background: #e0e7ff;
            color: #2a3d66;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            padding: 1.5rem;
            box-shadow: 0 8px 15px rgba(86, 112, 211, 0.2);
        }
        /* Flash message modal */
        #flashMessageModal .modal-content.border-success {
            border-left: 6px solid #4BB543;
            background: #e6f9e9;
            color: #2a3d66;
            font-weight: 600;
        }
        #flashMessageModal .modal-content.border-danger {
            border-left: 6px solid #d9534f;
            background: #fbeaea;
            color: #922b21;
            font-weight: 600;
        }
    </style>
</head>
<body>

<?= view('partials/navbar'); ?>

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
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title mb-3"><?= esc($project['name']) ?></h5>
                    </div>
                    <div class="card-footer bg-transparent d-grid gap-2">
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
              <input type="text" class="form-control" id="projectName" name="name" required placeholder="Masukkan nama project" />
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
              <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Success" width="80" />
          </div>
          <h5 class="text-success">✅ <?= session()->getFlashdata('success') ?></h5>
        <?php elseif (session()->getFlashdata('error')): ?>
          <div class="mb-3">
              <img src="https://cdn-icons-png.flaticon.com/512/1828/1828843.png" alt="Error" width="80" />
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
</html>
