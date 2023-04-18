<?php

namespace App\Models;

use CodeIgniter\Model;

class Api_Credential extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'api_credentials';
	protected $primaryKey           = 'api_credential_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"username",
		"email",
		"password",
		"role",
		"environment",
		"access_token",
		"expired_at",
		"created_at",
		"deleted_at"
	];
}
