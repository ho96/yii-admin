<?php

class AdminModule extends CWebModule{
	/*
	 * Add parameters here. You can access them using Yii::app()->controller->module->myParameter
	 */
	public $db;
    public $defaultController ="Site";
	private $_assetsUrl;
	
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
                'admin.models.*',
                'admin.components.*',
        ));
		
        Yii::app()->setComponents(
        	array(
		       'db'=>array(
		           'class'=>'CDbConnection',
		           'tablePrefix' => 'tbl_',
		           'connectionString'=>'sqlite:'.dirname(__FILE__).'/data/admin.sqlite',
		       ),
	           'errorHandler' => array(
	                'errorAction' => 'admin/site/error'
				),
		        'user' => array(
		                'class' => 'CWebUser',             
		                'loginUrl' => Yii::app()->createUrl('admin/site/login'),
		        ),
			)
		);
    }
	
	public function getAssetsUrl()
	{
	    if ($this->_assetsUrl === null)
	        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets'));
		
	    return $this->_assetsUrl;
	}
}