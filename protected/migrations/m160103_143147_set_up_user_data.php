<?php

class m160103_143147_set_up_user_data extends CDbMigration
{
	public function up()
	{
		$this->insertMultiple('user', [
			[
				'varName' => 'admin',
				'varPassword' => '21232f297a57a5a743894a0e4a801fc3', // admin
				'intRoleID' => 1
			],
			[
				'varName' => 'manager',
				'varPassword' => '1d0258c2440a8d19e716292b231e3190', // manager
				'intRoleID' => 2
			]
		]);
	}

	public function down()
	{
		$this->execute('DELETE FROM user WHERE intUserID in (1, 2)');
	}
}