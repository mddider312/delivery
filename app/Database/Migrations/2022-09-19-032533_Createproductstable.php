<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createproductstable extends Migration
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
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null' => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'description' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null' => true,
            ],
            'cost' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'null' => false,
            ],
            'selling_price' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'null' => false,
            ],
            'commission_rate' => [
                'type'           => 'INT',
                'constraint'     => 5,
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
            ],
        ];

        $forge->addField($fields);

        $forge->addPrimaryKey('id');

        $forge->createTable('products', true);
    }

    public function down()
    {
        $forge = Database::forge();

        $forge->dropTable('products');
    }
}
