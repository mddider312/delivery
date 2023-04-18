<?php

namespace App\Models;

use CodeIgniter\Model;

class Announcement extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'announcements';
	protected $primaryKey           = 'announcement_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"title",
        "content",
        "photo",
        "created_at",
        "updated_at",
        "deleted_at",
	];
}
