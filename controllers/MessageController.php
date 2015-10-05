<?php

class MessageController extends AdminController
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
				'actions'=>array('index','edit','dynamicfiles','savestylesheet'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$languages = Message::getLanguages();
		
		// Set language
		$language = '';
		if(isset($_POST['language']))
			$language = $_POST['language'];
		else
			$language = reset($languages);	
		
		$files = Message::getFiles($language);
		
		// Set file
		$file = '';
		if(isset($_POST['file']))
			$file = $_POST['file'];
		else
			$file = reset($files);

		$messages = Message::findAll($language, $file);
		$fileKeys = $messages[0];
		$fileValues = $messages[1];
		
		$this->render('index', array('languages' => $languages, 'files' => $files, 'language' => $language, 'file' => $file, 'fileKeys' => $fileKeys, 'fileValues' => $fileValues));
		
	}

	public function actionSavestylesheet()
	{
		$languages = Message::getLanguages();
		$model = new Message;
		
		$model->language = $_POST['language'];
		$model->file = $_POST['file'];
		$model->messageId = $_POST['message-id'];
		$model->message = $_POST['message-content'];
		$model->save();		
		$files = Message::getFiles($_POST['language']);
		
		Yii::app()->user->setFlash('success',Yii::t('AdminModule.messages', 'common.changessaved'));

		$this->render('edit', array('languages' => $languages, 'files' => $files, 'language' => $model->language, 'file' => $model->file, 'message' => $model->message, 'messageId' => $model->messageId));		
	}
	
	public function actionEdit()
	{
		$languages = Message::getLanguages();
		$model = new Message;
			
		$model->language = $_GET['language'];
		$model->file = $_GET['file'];
		$model->messageId = $_GET['message-id'];
		$model->message = Message::find($_GET['language'], $_GET['file'], $_GET['message-id']);
		$files = Message::getFiles($_GET['language']);

		$this->render('edit', array('languages' => $languages, 'files' => $files, 'language' => $model->language, 'file' => $model->file, 'message' => $model->message, 'messageId' => $model->messageId));
	}
	

	public function actionDynamicFiles()
	{
		$path = Yii::app()->basePath . '/messages/' . $_POST['language'];
		$results = scandir($path);
		foreach ($results as $key => $value) {
		    if ($value === '.' or $value === '..')
				unset($results[$key]);
		}
	    foreach($results as $value=>$name)
	    {
	        echo CHtml::tag('option', array('value'=>$name),CHtml::encode($name),true);
	    }
	}
}