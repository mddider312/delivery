<?php

namespace App\Models;

use CodeIgniter\Model;

class AppId_Area extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'appid_areas';
	protected $primaryKey           = 'appid_area_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"appid_id",
		"appid_area",
        "created_at",
        "deleted_at",
	];
}
