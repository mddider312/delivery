<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createpartnerstable extends Migration
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
            'adddress' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'contact_no' => [
                'type'           => 'VARCHAR',
                'constraint'     => 11,
                'null' => false,
            ],
            'balance_stock' => [
                'type'           => 'INT',
                'constraint'     => 10
            ],
            'commission' => [
                'type'       => 'INT',
                'constraint' => 10,
            ],
            'battery_to_collect' => [
                'type'       => 'INT',
                'constraint' => 10,
            ],
            'warning' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
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

        $forge->createTable('partners', true);
    }

    public function down()
    {
        $forge = Database::forge();

        $forge->dropTable('partners');
    }
}
