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
        body {
            background: linear-gradient(to bottom, #f3f4f6, #e5e7eb);
            color: #1f2937; /* text-gray-900 */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

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

        /* Navbar custom styles */
        .navbar {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1rem;
            background: white;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #4f46e5; /* Indigo 600 */
            letter-spacing: 1px;
        }

        .nav-link {
            font-weight: 600;
            color: #374151; /* Gray-700 */
            transition: color 0.3s ease;
            text-decoration: none;
        }
        .nav-link:hover, .nav-link:focus {
            color: #4f46e5;
            text-decoration: none;
        }

        .btn-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            border-radius: 50px;
            padding: 0.375rem 1rem;
            font-size: 0.9rem;
            color: #4f46e5;
            border: 2px solid #4f46e5;
            transition: background-color 0.3s, color 0.3s ease;
            text-decoration: none;
        }

        .btn-profile:hover, .btn-profile:focus {
            background-color: #4f46e5;
            color: #fff;
            text-decoration: none;
        }

        .btn-profile svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <a class="navbar-brand" href="#">TaskTim</a>
        <ul class="flex gap-6 list-none m-0 p-0">
            <li><a class="nav-link" href="/dashboard">Dashboard</a></li>
        </ul>
        <div>
            <?php if (isset($user) && !empty($user['nama'])): ?>
                <a href="/profile" class="btn-profile" aria-label="Profile <?= esc($user['nama']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
                        <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    <?= esc($user['nama']) ?>
                </a>
            <?php else: ?>
                <a href="/login" class="btn-indigo">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="px-8 py-12 max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-10 text-center drop-shadow-lg">
            <?= esc($project['name']) ?>
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
            <!-- Loop tiap kategori -->
            <?php
                $statuses = [
                    'todo' => ['label' => 'To Do', 'color' => 'indigo-500'],
                    'doing' => ['label' => 'Doing', 'color' => 'yellow-400'],
                    'done' => ['label' => 'Done', 'color' => 'green-500'],
                ];
                foreach ($statuses as $status => $info):
                    // Atur border color manual karena gak bisa PHP parsing tailwind classes dinamis
                    $borderColorClass = match ($status) {
                        'todo' => 'border-indigo-500',
                        'doing' => 'border-yellow-400',
                        'done' => 'border-green-500',
                        default => 'border-gray-300'
                    };
                    $textColorClass = match ($status) {
                        'todo' => 'text-indigo-600',
                        'doing' => 'text-yellow-600',
                        'done' => 'text-green-600',
                        default => 'text-gray-700'
                    };
                    $bgHoverClass = match ($status) {
                        'todo' => 'hover:bg-indigo-50',
                        'doing' => 'hover:bg-yellow-50',
                        'done' => 'hover:bg-green-50',
                        default => ''
                    };
                    $borderLeftClass = match ($status) {
                        'todo' => 'border-l-indigo-400',
                        'doing' => 'border-l-yellow-400',
                        'done' => 'border-l-green-400',
                        default => 'border-l-gray-300'
                    };
                    $textLinkClass = match ($status) {
                        'todo' => 'text-indigo-800',
                        'doing' => 'text-yellow-800',
                        'done' => 'text-green-800',
                        default => 'text-gray-800'
                    };
                    $btnEditTextColor = match ($status) {
                        'todo' => 'text-indigo-600 hover:text-indigo-900',
                        'doing' => 'text-yellow-600 hover:text-yellow-900',
                        'done' => 'text-green-600 hover:text-green-900',
                        default => 'text-gray-600 hover:text-gray-900'
                    };
            ?>
            <section class="p-6 bg-white shadow-xl rounded-xl border-t-4 <?= $borderColorClass ?>">
                <h3 class="text-xl font-bold <?= $textColorClass ?> mb-4"><?= $info['label'] ?></h3>
                <ul class="space-y-4">
                    <?php foreach ($tasks[$status] as $task): ?>
                    <li class="relative group bg-gray-100 rounded-lg <?= $borderLeftClass ?> border-l-4 <?= $bgHoverClass ?> transition">
                        <a href="<?= base_url('task/' . $task['id']) ?>" class="block p-4 font-semibold <?= $textLinkClass ?>">
                            <?= esc($task['title']) ?>
                        </a>
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex space-x-2 bg-white rounded shadow p-1">
                            <button 
                                data-id="<?= esc($task['id']) ?>" 
                                class="btn-edit <?= $btnEditTextColor ?>" 
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
                                <button type="submit" class="text-red-600 hover:text-red-900 focus:outline-none" aria-label="Hapus task">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
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
    <div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modalTambahTitle" aria-describedby="modalTambahDesc">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
            <h2 id="modalTambahTitle" class="text-2xl font-semibold text-indigo-600 mb-4 text-center">Tambah Sub-Tugas</h2>

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
