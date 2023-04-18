<?php

namespace App\Models;

use CodeIgniter\Model;

class AppId extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'appid';
	protected $primaryKey           = 'appid_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"appid",
        "created_at",
        "deleted_at",
	];
}
