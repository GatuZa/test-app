<?php

class m160103_142529_create_role_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('role', [
			'intRoleID' => 'TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT',
			'varName' => 'VARCHAR(50) NOT NULL',
			'PRIMARY KEY (`intRoleID`)'
		]);
	}

	public function down()
	{
		$this->execute('SET foreign_key_checks = 0');
		$this->dropTable('role');
	}
}