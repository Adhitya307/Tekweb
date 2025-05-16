<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5" style="max-width: 600px;">
    <h1 class="mb-4">Edit Task</h1>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url("task/{$task['id']}/update") ?>" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="title" class="form-label">Judul Task</label>
            <input
                type="text"
                class="form-control"
                id="title"
                name="title"
                value="<?= set_value('title', $task['title']) ?>"
                required
                minlength="3"
            >
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea
                class="form-control"
                id="description"
                name="description"
                rows="4"
            ><?= set_value('description', $task['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select
                class="form-select"
                id="status"
                name="status"
                required
            >
                <option value="todo" <?= set_value('status', $task['status']) == 'todo' ? 'selected' : '' ?>>Todo</option>
                <option value="doing" <?= set_value('status', $task['status']) == 'doing' ? 'selected' : '' ?>>Doing</option>
                <option value="done" <?= set_value('status', $task['status']) == 'done' ? 'selected' : '' ?>>Done</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="<?= base_url("project/{$task['project_id']}") ?>" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
