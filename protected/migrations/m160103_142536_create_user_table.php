<?php

class m160103_142536_create_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', [
			'intUserID' => 'INT(2) UNSIGNED NOT NULL AUTO_INCREMENT',
			'varName' => 'CHAR(20) NOT NULL',
			'varPassword' => 'CHAR(40) NULL DEFAULT NULL',
			'intRoleID' => 'TINYINT(1) UNSIGNED NOT NULL',
			'isActive' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 1',
			'PRIMARY KEY (`intUserID`)',
			'UNIQUE INDEX `varName` (`varName`)',
			'INDEX `FK_user_role` (`intRoleID`)',
			'INDEX `isActive` (`isActive`)',
			'CONSTRAINT `FK_user_role` FOREIGN KEY (`intRoleID`) REFERENCES `role` (`intRoleID`) ON UPDATE CASCADE'
		]);
	}

	public function down()
	{
		$this->dropTable('user');
	}
}