<?php

namespace App\Models;

use CodeIgniter\Model;

class Commission extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'commissions';
	protected $primaryKey           = 'commission_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"partner_id",
		"agent_id",
		"amount",
		"is_refunded",
		"status",
		"order_id",
		"created_at",
		"deleted_at"
	];
}
