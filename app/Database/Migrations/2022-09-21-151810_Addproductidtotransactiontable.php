<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Addproductidtotransactiontable extends Migration
{
	public function up()
	{
		$forge = Database::forge();
		$fields = [
			'product_id' => [
				'type'       => 'INT',
                'constraint' => 50,
				'null'	=> true,
			]
		];

		$forge->addColumn('transactions',$fields);
	}

	public function down()
	{
		$forge = Database::forge();

		$forge->dropColumn('transactions','product_id');
	}
}
