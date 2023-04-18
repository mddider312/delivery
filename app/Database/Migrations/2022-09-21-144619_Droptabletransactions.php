<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Database;

class Droptabletransactions extends Migration
{
	public function up()
	{
		$forge = Database::forge();

        $forge->dropTable('transactions');
	}

	public function down()
	{
		$forge = Database::forge();

        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'stock_in' => [
                'type'       => 'INT',
                'constraint' => 50,
            ],
            'stock_out' => [
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

        $forge->createTable('transactions', true);
	}
}
