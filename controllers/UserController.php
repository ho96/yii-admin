<?php

class UserController extends AdminController
{
	public $layout = '/layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		$filters = array(
			'accessControl', // perform access control for CRUD operations
		);
		
		return array_merge($filters, parent::filters());
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('update'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionUpdate()
	{
		$model = User::model()->findByPk(1);
		
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			$model->username = trim(strtolower($model->username));
			
			if($model->save())
			{
				Yii::app()->user->setFlash('success',Yii::t('AdminModule.messages', 'common.changessaved'));
			}
		}

        $model->password = null;
		$model->repeatPassword = null;
		
		$this->render('update',array(
			'model'=>$model,
		));
	}
}
