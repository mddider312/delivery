<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createtabletransactions extends Migration
{
	public function up()
	{
		$forge = Database::forge();

        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
			'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
			'partner_id' => [
                'type'       => 'INT',
                'constraint' => 50,
				'null'	=> true,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
        ];

        $forge->addField($fields);

        $forge->addPrimaryKey('id');

        $forge->createTable('transactions', true);
	}

	public function down()
	{
		$forge = Database::forge();

        $forge->dropTable('transactions');
	}
}
