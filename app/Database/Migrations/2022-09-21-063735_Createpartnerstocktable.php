<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createpartnerstocktable extends Migration
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
            'partner_id' => [
                'type'       => 'INT',
                'constraint' => 10,
            ],
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 10,
            ], 
			'quantity' => [
                'type'           => 'INT',
                'constraint'     => 50,
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

        $forge->createTable('partnerstocks', true);
    }

    public function down()
    {
        $forge = Database::forge();

        $forge->dropTable('partnerstocks');
    }
}
