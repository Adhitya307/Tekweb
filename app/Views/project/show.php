<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Sub-Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen px-6 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-3xl font-bold text-indigo-700 mb-4"><?= esc($task['title']) ?></h1>
        <p class="text-gray-700 mb-2"><strong>Deskripsi:</strong></p>
        <p class="text-gray-600 mb-4"><?= esc($task['description']) ?: 'Tidak ada deskripsi.' ?></p>
        <p><strong>Status:</strong> 
            <span class="inline-block px-3 py-1 rounded-full 
                <?= $task['status'] == 'todo' ? 'bg-indigo-100 text-indigo-700' : ($task['status'] == 'doing' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') ?>">
                <?= ucfirst($task['status']) ?>
            </span>
        </p>
        <div class="mt-6">
            <a href="<?= base_url('project/' . $project['id']) ?>" class="text-indigo-600 hover:underline">← Kembali ke proyek</a>
        </div>
    </div>
</body>
</html>
