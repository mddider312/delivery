<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Createvoucherstable extends Migration
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
                'constraint' => 50,
                'null' => false,
            ],
            'code' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null' => false,
                'unique'     => true,
            ],
            'discount_amount' => [
                'type'           => 'FLOAT',
                // 'constraint'     => 5,
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

        $forge->createTable('vouchers', true);
    }

    public function down()
    {
        $forge = Database::forge();

        $forge->dropTable('vouchers');
    }
}
