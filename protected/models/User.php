<?php

Yii::import('application.models._base.BaseUser');

/**
 * Class User
 */
class User extends BaseUser
{
	/**
	 * User is active
	 */
	const STATUS_ACTIVE = 1;

	/**
	 * User is not active
	 */
	const STATUS_INACTIVE = 0;

	/**
	 * User is administrator
	 */
	const ROLE_ADMIN = 1;

	/**
	 * @param string $className
	 *
	 * @return CActiveRecord
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'intUserID' => 'ID',
			'varName' => Yii::t('app', 'Name'),
			'varPassword' => Yii::t('app', 'Password'),
			'intRoleID' => Yii::t('app', 'Role'),
			'isActive' => Yii::t('app', 'Active')
		];
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			['varName, varPassword, intRoleID', 'required'],
			['varName', 'length', 'max' => 20],
			['varName', 'unique'],
			['isActive', 'length', 'max' => 1],
			['isActive', 'boolean'],
			['varPassword', 'length', 'max' => 40],
			['intRoleID', 'length', 'max' => 1],
			['varName, isActive', 'default', 'setOnEmpty' => true, 'value' => null],
			['intUserID, varName, isActive, varPassword, intRoleID', 'safe', 'on' => 'search']
		];
	}

	/**
	 * @param $password
	 *
	 * @return string|null
	 */
	public function encryptPassword($password = false)
	{
		if (!empty($password)) {
			return md5($password);
		}

		return null;
	}

	/**
	 * @param $password
	 *
	 * @return bool
	 */
	public function validatePassword($password)
	{
		return ($this->varPassword == $this->encryptPassword($password));
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = ['intRole'];

		$criteria->compare('intUserID', $this->intUserID);
		$criteria->compare('varName', $this->varName, true);
		$criteria->compare('varPassword', $this->varPassword);
		$criteria->compare('intRoleID', $this->intRoleID);
		$criteria->compare('isActive', $this->isActive);

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
			'sort' => [
				'attributes' => [
					'intRole' => [
						'asc' => 'intRole.varName',
						'desc' => 'intRole.varName DESC',
					],
					'*'
				]
			]
		]);
	}
}
