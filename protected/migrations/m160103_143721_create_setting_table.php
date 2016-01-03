<?php

class m160103_143721_create_setting_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('setting', [
			'intSettingID' => 'TINYINT(2) UNSIGNED NOT NULL AUTO_INCREMENT',
			'varName' => 'VARCHAR(50) NOT NULL',
			'varValue' => 'VARCHAR(1000) NOT NULL',
			'PRIMARY KEY (`intSettingID`)'
		]);
	}

	public function down()
	{
		$this->dropTable('setting');
	}
}