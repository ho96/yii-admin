<?php
if(file_exists(dirname(__FILE__) . '/../../../assets/lib/extplorer')):
?>
<iframe src="<?= $this->module->assetsUrl . '/lib/extplorer' ?>">

</iframe>
<?php
	Yii::app()->clientScript->registerScript('iframes',"
		resizeIframe();
		
		$(window).resize(function(){
			resizeIframe();
		});
		
		function resizeIframe()
		{
			$('iframe').attr('width',$('#box').width());
			$('iframe').attr('height','600');			
		}
	");
	
	Yii::app()->clientScript->registerCss('iframes',"
		#content
		{
			padding:0px;
		}
	");
?>
<?php
else:
?>
You need to put <a target="_blank" href="http://www.extplorer.net/">extplorer</a> folder in <b>modules/admin/assets/lib</b>
<?php
endif;
?>