<div class="center margin-bottom-20">
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-selector-form',
	'enableClientValidation'=>false,
	'action'=>Yii::app()->createUrl('admin/message/index', array('lang' => Yii::app()->language)),
));	
	echo CHtml::dropDownList('language',$language, $languages,
	array(
	'ajax' => array(
		'type'=>'POST', //request type
		'url'=>CController::createUrl('message/dynamicfiles'), //url to call.
		//Style: CController::createUrl('currentController/methodToCall')
		'update'=>'#file', //selector to update
		//'data'=>'js:javascript statement' 
		//leave out the data key to pass all form values through
		)
	)); 
?>
&nbsp;&nbsp;
<?php
	//empty since it will be filled by the other dropdown
	echo CHtml::dropDownList('file',$file, $files);
?>
&nbsp;&nbsp;
<?php
	echo CHtml::hiddenField('lang', Yii::app()->language);
	echo CHtml::submitButton(Yii::t('AdminModule.messages', 'messages.editfile'));
$this->endWidget();
?>
</div>