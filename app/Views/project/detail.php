<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Detail Proyek - <?= esc($project['name']) ?></title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= base_url('css/detail.css') ?>" />

    <style>
        .btn-indigo {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-indigo:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-100 to-gray-200 text-gray-900 font-sans min-h-screen">

    <main class="px-8 py-12 max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-10 text-center drop-shadow-lg">
            <?= esc($project['name']) ?>
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
            <!-- Loop tiap kategori -->
            <?php
                $statuses = [
                    'todo' => ['label' => 'To Do', 'color' => 'indigo'],
                    'doing' => ['label' => 'Doing', 'color' => 'yellow'],
                    'done' => ['label' => 'Done', 'color' => 'green'],
                ];
                foreach ($statuses as $status => $info):
            ?>
            <section class="p-6 bg-white shadow-xl rounded-xl border-t-4 border-<?= $info['color'] ?>-500">
                <h3 class="text-xl font-bold text-<?= $info['color'] ?>-600 mb-4"><?= $info['label'] ?></h3>
                <ul class="space-y-4">
                    <?php foreach ($tasks[$status] as $task): ?>
                    <li class="relative group bg-gray-100 rounded-lg border-l-4 border-<?= $info['color'] ?>-400 hover:bg-<?= $info['color'] ?>-50 transition">
                        <a href="<?= base_url('task/' . $task['id']) ?>" class="block p-4 font-semibold text-<?= $info['color'] ?>-800">
                            <?= esc($task['title']) ?>
                        </a>
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2 bg-white rounded shadow p-1">
                            <button 
                                data-id="<?= esc($task['id']) ?>" 
                                class="btn-edit text-<?= $info['color'] ?>-600 hover:text-<?= $info['color'] ?>-900" 
                                title="Edit"
                                type="button"
                            >
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h18"/>
                                </svg>
                            </button>

                            <form action="<?= base_url('task/' . $task['id']) ?>" method="POST" class="inline delete-form" onsubmit="return confirmDelete(event)">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" class="text-red-600 hover:text-red-900 focus:outline-none">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endforeach; ?>
        </div>

<!-- Tombol Tambah dan Kembali -->
<div class="mt-12 flex justify-between">
    <a href="/dashboard" class="btn-indigo bg-gray-500 hover:bg-gray-600 self-center">
        ← Kembali
    </a>
    <button class="btn-indigo" onclick="openModalTambah()">Tambah Sub-Tugas</button>
</div>

    </main>

    <!-- Modal Tambah Sub-Tugas -->
    <div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" role="dialog" aria-modal="true">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-4 text-center">Tambah Sub-Tugas</h2>

            <form action="<?= base_url('project/' . $project['id'] . '/task/store') ?>" method="POST" class="space-y-6" novalidate>
                <?= csrf_field() ?>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Sub-Tugas</label>
                    <input type="text" name="title" id="title" value="<?= esc(old('title')) ?>" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" />
                    <?php if (session()->getFlashdata('errors')['title'] ?? false): ?>
                    <div class="text-red-500 text-sm mt-1">
                        <?= esc(session()->getFlashdata('errors')['title']) ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"><?= esc(old('description')) ?></textarea>
                    <?php if (session()->getFlashdata('errors')['description'] ?? false): ?>
                    <div class="text-red-500 text-sm mt-1">
                        <?= esc(session()->getFlashdata('errors')['description']) ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="todo" <?= old('status') == 'todo' ? 'selected' : '' ?>>To Do</option>
                        <option value="doing" <?= old('status') == 'doing' ? 'selected' : '' ?>>Doing</option>
                        <option value="done" <?= old('status') == 'done' ? 'selected' : '' ?>>Done</option>
                    </select>
                    <?php if (session()->getFlashdata('errors')['status'] ?? false): ?>
                    <div class="text-red-500 text-sm mt-1">
                        <?= esc(session()->getFlashdata('errors')['status']) ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModalTambah()" class="btn-indigo bg-gray-400 hover:bg-gray-500">Batal</button>
                    <button type="submit" class="btn-indigo">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        function openModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });

            return false;
        }

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                if (id) window.location.href = `/task/${id}/edit`;
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === "Escape") closeModalTambah();
        });
    </script>

    <!-- Flash success message -->
    <?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: "<?= esc(session()->getFlashdata('success')) ?>",
            icon: 'success',
            confirmButtonColor: '#4f46e5',
            confirmButtonText: 'OK'
        });
    </script>
    <?php endif; ?>

</body>
</html>
