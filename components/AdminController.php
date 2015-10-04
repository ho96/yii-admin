<?php

class AdminController extends CController
{
	public $breadcrumbs=array();
	public $paramKeys;
	public $paramValues;
	public $languages = array('en','es');
			
	public function init()
	{
		parent::init();
	}
	
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		
		$usedLanguage = Yii::app()->request->getQuery('lang');
		
		// Setting the language.....................
		if(isset($usedLanguage) && $this->checkLanguage($usedLanguage))
		{
			Yii::app()->setLanguage($usedLanguage);
		}
		else
		{
			$usedLanguage = $this->getNavigatorLanguage();
			if(!$this->checkLanguage($usedLanguage))
				$usedLanguage = 'en';
			Yii::app()->setLanguage($usedLanguage);
		}
		
		$this->paramKeys = array_keys($_GET);
		$this->paramValues = array_values($_GET);
		
		return true;
	}
	
	public function getNavigatorLanguage()
	{
		$language = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$language = strtolower(substr(chop($language[0]),0,2));
		return $language;
	}
	
	public function checkLanguage($language)
	{
		foreach($this->languages as $lang)
		{
			if($language === $lang)
				return true;	
		}
		return false;				
	}
}
	