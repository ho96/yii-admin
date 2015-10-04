<?php $this->renderPartial('/message/_selectors',array(
	'languages'=>$languages,
	'files'=>$files,
	'language'=>$language,
	'file'=>$file,
)); ?>
<?php
	Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl . '/js/tinymce/tinymce.min.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScript('messagesjs','
		tinymce.init({'
			. (file_exists(dirname(__FILE__) . '/../../assets/js/tinymce/langs/' . Yii::app()->getLanguage() . '.js') ? ('language: "' . Yii::app()->getLanguage() . '",') : '') .
		    'selector: "#messages-textarea",
		    theme: "modern",
		    plugins: [
		        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
		        "searchreplace wordcount visualblocks visualchars code fullscreen",
		        "insertdatetime media nonbreaking save table contextmenu directionality",
		        "emoticons template paste textcolor colorpicker textpattern"
		    ],
		    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image pastetext",
		    toolbar2: "forecolor backcolor emoticons | fontselect | fontsizeselect | print preview code pagebreak media",
		    image_advtab: true,
		    templates: [
		        {title: "Test template 1", content: "Test 1"},
		        {title: "Test template 2", content: "Test 2"}
		    ],
		    forced_root_block : "",
			content_css : "css/custom_content.css",
			theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
			font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
		});	
	');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-message-form',
	'enableClientValidation'=>false,
	'action'=>Yii::app()->createUrl('admin/message/savestylesheet', array('lang' => Yii::app()->language)),
));	
?>
<input type="hidden" name="message-id" value="<?= $messageId ?>" />
<input type="hidden" name="language" value="<?= $language ?>" />
<input type="hidden" name="file" value="<?= $file ?>" />
<textarea name="message-content" id="messages-textarea">
	<?= $message ?>
</textarea>
<div class="center padding-20-0">
<?php 
	echo CHtml::submitButton(Yii::t('AdminModule.messages', 'common.save'));
?>
</div>
<?php
	$this->endWidget();
?>