<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    
    <title>Detail Proyek - <?= esc($project['name']) ?></title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= base_url('css/detail.css') ?>">
</head>
<body class="bg-gradient-to-b from-gray-100 to-gray-200 text-gray-900 font-sans min-h-screen">

<main class="px-8 py-12">
    <h1 class="text-4xl font-extrabold text-indigo-700 mb-10 text-center drop-shadow-lg">
        <?= esc($project['name']) ?>
    </h1>

    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-10">

        <!-- To Do -->
        <section class="p-6 bg-white shadow-xl rounded-xl border-t-4 border-indigo-500">
            <h3 class="text-xl font-bold text-indigo-600 mb-4">To Do</h3>
            <ul class="space-y-4">
                <?php foreach ($tasks['todo'] as $task): ?>
                    <li>
                        <a href="<?= base_url('task/' . $task['id']) ?>"
                           class="block p-4 bg-gray-100 rounded-lg border-l-4 border-indigo-400 hover:bg-indigo-50 transition">
                            <span class="font-semibold text-indigo-800"><?= esc($task['title']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Doing -->
        <section class="p-6 bg-white shadow-xl rounded-xl border-t-4 border-yellow-500">
            <h3 class="text-xl font-bold text-yellow-600 mb-4">Doing</h3>
            <ul class="space-y-4">
                <?php foreach ($tasks['doing'] as $task): ?>
                    <li>
                        <a href="<?= base_url('task/' . $task['id']) ?>"
                           class="block p-4 bg-gray-100 rounded-lg border-l-4 border-yellow-400 hover:bg-yellow-50 transition">
                            <span class="font-semibold text-yellow-800"><?= esc($task['title']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Done -->
        <section class="p-6 bg-white shadow-xl rounded-xl border-t-4 border-green-500">
            <h3 class="text-xl font-bold text-green-600 mb-4">Done</h3>
            <ul class="space-y-4">
                <?php foreach ($tasks['done'] as $task): ?>
                    <li>
                        <a href="<?= base_url('task/' . $task['id']) ?>"
                           class="block p-4 bg-gray-100 rounded-lg border-l-4 border-green-400 hover:bg-green-50 transition">
                            <span class="font-semibold text-green-800"><?= esc($task['title']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

    </div>

    <!-- Tombol Modal -->
    <div class="max-w-7xl mx-auto mt-12 flex justify-end">
        <button class="btn-indigo" onclick="openModal()">Tambah Sub-Tugas</button>
    </div>
</main>

<!-- Modal -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white modal-content w-full max-w-md p-6">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-4 text-center">Tambah Sub-Tugas</h2>

        <form action="<?= base_url('project/' . $project['id'] . '/task/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul Sub-Tugas:</label>
                <input type="text" name="title" id="title" value="<?= old('title') ?>" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                <?php if (isset($errors['title'])): ?>
                    <div class="text-red-500 text-sm mt-1"><?= esc($errors['title']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select name="status" id="status"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="todo" <?= old('status') == 'todo' ? 'selected' : '' ?>>To Do</option>
                    <option value="doing" <?= old('status') == 'doing' ? 'selected' : '' ?>>Doing</option>
                    <option value="done" <?= old('status') == 'done' ? 'selected' : '' ?>>Done</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-between items-center">
                <button type="submit" class="btn-indigo w-full">Simpan Sub-Tugas</button>
            </div>
        </form>

        <!-- Tombol Tutup -->
        <div class="mt-4 text-center">
            <button class="text-red-600 hover:underline" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>

</body>
</html>
