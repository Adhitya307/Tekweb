<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;
use App\Models\UserModel;
use App\Models\ProjectTaskModel;

class ProjectController extends BaseController
{
    public function detail($id)
    {
        $projectModel = new ProjectModel();
        $taskModel = new ProjectTaskModel();

        // Validasi ID proyek
        $project = $projectModel->find($id);
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil semua tugas yang terkait dengan proyek ini
        $allTasks = $taskModel->where('project_id', $id)->findAll();

        // Kelompokkan tugas berdasarkan status
        $tasks = [
            'todo' => [],
            'doing' => [],
            'done' => [],
        ];

        foreach ($allTasks as $task) {
            $status = $task['status'];
            if (isset($tasks[$status])) {
                $tasks[$status][] = $task;
            }
        }

        return view('project/detail', [
            'project' => $project,
            'tasks'   => $tasks
        ]);
    }

    public function inviteMember()
    {
        $email     = $this->request->getPost('email');
        $projectId = $this->request->getPost('project_id');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Email belum terdaftar. Silakan mendaftar terlebih dahulu.')
                ->with('undangan_email', $email);
        }

        $projectMemberModel = new ProjectMemberModel();
        $isMember = $projectMemberModel
            ->where('project_id', $projectId)
            ->where('user_id', $user['id'])
            ->first();

        if ($isMember) {
            return redirect()->back()->with('error', 'User sudah menjadi anggota project ini.');
        }

        $projectMemberModel->insert([
            'project_id' => $projectId,
            'user_id'    => $user['id'],
            'role'       => 'anggota',
            'invited_at' => date('Y-m-d H:i:s'),
            'status'     => 'active'
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function create()
    {
        $projectModel = new ProjectModel();
        $memberModel  = new ProjectMemberModel();

        $user = session()->get('user');
        $projectName = $this->request->getPost('name');

        if (!$projectName) {
            return redirect()->to('/dashboard')->with('error', 'Nama project harus diisi!');
        }

        $projectId = $projectModel->insert(['name' => $projectName]);

        if (!$projectId) {
            return redirect()->to('/dashboard')->with('error', 'Gagal membuat project.');
        }

        $memberModel->insert([
            'project_id' => $projectId,
            'user_id'    => $user['id'],
            'role'       => 'ketua',
            'status'     => 'active',
        ]);

        return redirect()->to('/dashboard')->with('success', 'Project berhasil dibuat!');
    }

    public function update()
    {
        $id   = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        $projectModel = new ProjectModel();
        $projectModel->update($id, ['name' => $name]);

        return redirect()->to('/dashboard')->with('success', 'Nama proyek berhasil diperbarui.');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $projectModel = new ProjectModel();
        $projectModel->delete($id);

        return redirect()->to('/dashboard')->with('success', 'Proyek berhasil dihapus.');
    }

    public function createTask($projectId)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->find($projectId);

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('project/create_task', ['project' => $project]);
    }

    public function storeTask($projectId)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->find($projectId);

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (!$this->validate([
            'title'  => 'required|min_length[3]',
            'status' => 'required|in_list[todo,doing,done]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $taskModel = new ProjectTaskModel();
        $taskModel->save([
            'project_id'  => $projectId,
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?: 'todo',
        ]);

        return redirect()->to("/projects/$projectId")->with('success', 'Sub-tugas berhasil dibuat!');
    }

    public function showProjectDetail($projectId)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->find($projectId);
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    
        $taskModel = new ProjectTaskModel();
        $allTasks = $taskModel->where('project_id', $projectId)->findAll();
    
        $tasks = [
            'todo' => [],
            'doing' => [],
            'done' => [],
        ];
    
        foreach ($allTasks as $task) {
            $status = $task['status'];
            if (isset($tasks[$status])) {
                $tasks[$status][] = $task;
            }
        }
    
        return view('project/detail', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }

    public function showTask($taskId)
    {
        $taskModel = new ProjectTaskModel();
        $task = $taskModel->find($taskId);

        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tugas tidak ditemukan.");
        }

        $projectModel = new ProjectModel();
        $project = $projectModel->find($task['project_id']);

        return view('project/show', [
            'task'    => $task,
            'project' => $project
        ]);
    }

    public function showProjectMembers($id)
    {
        $memberModel = new ProjectMemberModel();
        $userModel = new UserModel(); // Load the User model to get 'nama'
    
        // Get members with the associated user data (like 'nama')
        $members = $memberModel->getMembersByProject($id);
        foreach ($members as &$member) {
            $user = $userModel->getUserById($member['user_id']);  // Gunakan fungsi baru untuk mendapatkan nama
            $member['nama'] = $user['nama']; // Menambahkan nama ke dalam array anggota
        }
    
        $data['members'] = $members;
    
        // Pastikan project juga dikirimkan ke view jika dibutuhkan
        $projectModel = new ProjectModel();
        $data['project'] = $projectModel->find($id);
    
        // Periksa apakah pengguna saat ini adalah ketua proyek
        $user = session()->get('user');
        $data['isKetua'] = $memberModel->where('project_id', $id)
                                       ->where('user_id', $user['id'])
                                       ->where('role', 'ketua')
                                       ->countAllResults() > 0;
    
        // Tampilkan daftar anggota proyek
        return view('project_detail', $data);
    }
       
}
