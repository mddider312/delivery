<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createcustomertabele extends Migration
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
			'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
			'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
				'null'	=> false,
            ],
            'contact_no' => [
                'type'       => 'INT',
                'constraint' => 50,
				'null'	=> false,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'postal_code' => [
				'type'       => 'INT',
                'constraint' => 6,
				'null'	=> false,
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

        $forge->createTable('customers', true);
	}

	public function down()
	{
		$forge = Database::forge();

        $forge->dropTable('customers');
	}
}
