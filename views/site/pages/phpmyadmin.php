<?php
if(file_exists(dirname(__FILE__) . '/../../../assets/lib/phpmyadmin')):
?>
<iframe src="<?= $this->module->assetsUrl . '/lib/phpmyadmin' ?>">
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
You need to put <a target="_blank" href="https://www.phpmyadmin.net/">phpmyadmin</a> folder in <b>modules/admin/assets/lib</b>
<?php
endif;
?>