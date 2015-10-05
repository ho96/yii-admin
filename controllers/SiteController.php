<?php

class SiteController extends AdminController
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
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
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
				'actions'=>array('login','error'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('index','logout','messages','dynamicfiles','phpliteadmin',
								'extplorer','phpmyadmin','about','page'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
			$this->redirect(array('site/index'));
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$this->redirect(array('site/index', 'lang' => Yii::app()->language));
			}				
		}
		// display the login form
		$this->render('login',array('model'=>$model, 'lang' => Yii::app()->language));
	}
	
	public function actionIndex()
	{
		$this->render('index');	
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login', 'lang' => Yii::app()->language));
	}
}
