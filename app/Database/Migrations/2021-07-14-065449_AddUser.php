<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'			=> 'INT',
				'constraint'	=> 5,
				'unsign'		=> TRUE,
				'auto_increment' => TRUE
			],
			'name' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'			=> FALSE,
			],
			'email' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'			=> FALSE,
				'unique'		=> TRUE
			],
			'password' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 255,
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
		$this->forge->createTable('user');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
