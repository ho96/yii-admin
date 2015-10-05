<iframe src="<?= $this->module->assetsUrl . '/lib/phpliteadmin' ?>">
	
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