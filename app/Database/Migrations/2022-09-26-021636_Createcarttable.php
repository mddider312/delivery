<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createcarttable extends Migration
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
			'customer_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
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
            ]
        ];

        $forge->addField($fields);

        $forge->addPrimaryKey('id');

        $forge->createTable('carts', true);
	}

	public function down()
	{
		$forge = Database::forge();

        $forge->dropTable('carts');
	}
}
