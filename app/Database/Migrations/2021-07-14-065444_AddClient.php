<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClient extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'constraint'	=> 5,
				'unsingn'		=> TRUE,
				'auto_increment' => TRUE
			],
			'name' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'			=> False
			],
			'email' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'			=> FALSE,
				'unique'		=> TRUE
			],
			'retainer_fee' => [
				'type'			=> 'INT',
				'constraint'	=> 20,
				'null'			=> FALSE,
				'unique'		=> TRUE
			],
			'update_at' => [
				'type'			=> 'datetime',
				'null'			=> TRUE
			],
			'create_at datetime default current_timestamp',
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('client');
	}

	public function down()
	{
		$this->forge->dropTable('client');
	}
}
