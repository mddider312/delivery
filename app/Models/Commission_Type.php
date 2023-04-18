<?php

namespace App\Models;

use CodeIgniter\Model;

class Commission_Type extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'commissions_types';
	protected $primaryKey           = 'commission_type_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
	    "type",
	    "percentage",
		"created_at",
		"deleted_at"
	];
}
