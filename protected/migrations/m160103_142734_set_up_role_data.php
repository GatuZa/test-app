<?php

class m160103_142734_set_up_role_data extends CDbMigration
{
	public function up()
	{
		$this->insertMultiple('role', [
			['varName' => 'Administrator'],
			['varName' => 'Manager']
		]);
	}

	public function down()
	{
		$this->execute('DELETE FROM role WHERE intRoleID IN (1, 2)');
	}
}