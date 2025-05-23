<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['task_id', 'user_id', 'comment', 'created_at'];
    protected $useTimestamps = false;
}
