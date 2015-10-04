<?php

class User extends CActiveRecord
{
	public $repeatPassword;
	public $unecryptedPassword;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-z]+)$/'),
            array('password, repeatPassword, email', 'length', 'min'=>6, 'max'=>100),
			array('password', 'compare', 'compareAttribute'=>'repeatPassword'),
            array('username', 'length', 'min'=>5, 'max'=>100),
			array('username, email', 'unique'),
			array('username, email', 'required'),
			array('username, password','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('email', 'email'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('AdminModule.messages', 'profile.id'),
			'username' => Yii::t('AdminModule.messages', 'profile.username'),
			'password' => Yii::t('AdminModule.messages', 'profile.password'),
			'email' => Yii::t('AdminModule.messages', 'profile.email'),
			'repeatPassword' => Yii::t('AdminModule.messages', 'profile.repeatpassword'),
		);
	}
	
	protected function beforeSave()
	{
		$this->username = trim(strtolower($this->username));
		
		if($this->password === ''){
			$model2 = User::model()->findByPk($this->id);
			$this->password = $model2->password;
			$this->repeatPassword = $model2->password;
		}
		elseif($this->repeatPassword !== null) {
			$this->unecryptedPassword = $this->password;
			$this->password = CPasswordHelper::hashPassword($this->password);
			$this->repeatPassword = CPasswordHelper::hashPassword($this->repeatPassword);					
		}
	
		return true;
	}

	protected function afterSave()
	{
		if($this->unecryptedPassword != null)
		{
			$phpLiteConfig = dirname(__FILE__) . '/../assets/lib/phpliteadmin/phpliteadmin.config.php';
			$phpLiteConfigContents = file_get_contents($phpLiteConfig);
			$phpLiteConfigNewContents = preg_replace('/\$password ?= ?\\\'(.*)\\\' ?;/', '$password = \''. addslashes($this->unecryptedPassword) . '\';', $phpLiteConfigContents);
			file_put_contents($phpLiteConfig, $phpLiteConfigNewContents);
		}		
		
		return true;
	}
}
