<?php
	$lang = Yii::app()->language;
	
	header('Content-Type: text/html; charset=utf-8');
	
	
	Yii::app()->clientScript->registerCss('maincss','		
	');
	Yii::app()->clientScript->registerScript('mainjs','		
	');

	Yii::app()->clientScript->registerCssFile($this->module->assetsUrl . '/css/style.css');
	Yii::app()->clientScript->registerCssFile($this->module->assetsUrl . '/css/form.css');
	Yii::app()->clientScript->registerCoreScript('jquery');
	Yii::app()->clientScript->coreScriptPosition=CClientScript::POS_END;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin area</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
	<div id="responsive-menu">
		<span id="insertHere"></span>
	</div>
	<div id="box">
		<header>
			<?= CHtml::image($this->module->assetsUrl . '/images/user.gif', 'user', array('id' => 'title-image')) ?>
			<?= CHtml::link('<span id="title"><b>' . Yii::app()->name . '</b><br/>' . Yii::t('AdminModule.messages', 'layout.administration') . '</span>',array('/admin/site/login', 'lang' => $lang)) ?>
			<?php if(!Yii::app()->user->isGuest): ?>
				<div id="logout"><?= CHtml::link(CHtml::image($this->module->assetsUrl . '/images/logout.png', 'logout', array('title' => Yii::t('AdminModule.messages', 'layout.logout'))), array('site/logout', 'lang' => $lang)); ?></div>
			<?php endif; ?>
			<div id="home"><?= CHtml::link(CHtml::image($this->module->assetsUrl . '/images/home.png', 'home', array('title' => Yii::t('AdminModule.messages', 'layout.gobackmainsite'))), array('/site/index', 'lang' => $lang)); ?></div>
			<div id="flags"><?php printFlags($lang, $this->paramKeys, $this->paramValues, $this->languages); ?></div>
			<?php if(!Yii::app()->user->isGuest): ?>
				<div id="welcome"><?= Yii::t('AdminModule.messages', 'layout.welcome') . ' ' .  Yii::app()->user->name ?>!</div>
			<?php endif; ?>
			<div class="clear"></div>
		</header>
		<nav>
		<?php
		if(!Yii::app()->user->isGuest):
			$this->widget('admin.extensions.multilevelhorizontalmenu.MultilevelHorizontalMenu',
			array(
       'menu'=>array(
              array('url'=>array(
                           'route'=>'admin/site/index','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.home')),
              array('url'=>array(
                           'route'=>'admin/user/update','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.profile')),
              array('url'=>array(
                           'route'=>'admin/message/index','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.messages')),
              array('url'=>array(
                           'route'=>'admin/site/page/view/phpmyadmin','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.phpmyadmin')),                           
              array('url'=>array(
                           'route'=>'admin/site/page/view/phpliteadmin','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.phpliteadmin')),
              array('url'=>array(
                           'route'=>'admin/site/page/view/extplorer','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.extplorer')),
              array('url'=>array(
                           'route'=>'admin/site/page/view/phpinfo','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.phpinfo')),
              array('url'=>array(
                           'route'=>'admin/site/page/view/about','params'=>array('lang'=>$lang)),
                           'label'=>Yii::t('AdminModule.messages', 'layout.about')),
                           
	          array("url"=>array(),
	                       "label"=>"Dummy menu",
	              array("url"=>array(
	                           "link"=>"http://www.yiiframework.com",
	                           "htmlOptions"=>array("target"=>"_BLANK")),
	                           "label"=>"Yii Framework"),
	          array("url"=>array(
	                       "route"=>"/product/clothes"),
	                       "label"=>"Clothes",
	          array("url"=>array(
	                       "route"=>"/product/men",
	                       "params"=>array("id"=>3),
	                       "htmlOptions"=>array("title"=>"title")),
	                       "label"=>"Men"),
	            array("url"=>"",
	                         "label"=>"Women",
	                array("url"=>array(
	                             "route"=>"/product/scarves",
	                             "params"=>array("id"=>5)),
	                             "label"=>"Scarves"))),
	              array("url"=>array(
	                           "route"=>"site/menuDoc"),
	                           "label"=>"Disabled Link",
	                           "disabled"=>true),
	                )
          
                      ),
			)
			);
		endif;
		?>
		</nav>
		<?php if(Yii::app()->user->hasFlash('success')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
		<?php elseif(Yii::app()->user->hasFlash('error')): ?>
		<div class="flash-error">
			<?php echo Yii::app()->user->getFlash('error'); ?>
		</div>
		<?php endif; ?>
		<?php echo $content; ?>
		<footer>
			Administration developed by <?= CHtml::link('http://ho96.com', 'http://ho96.com', array('target' => '_blank'))?>
			<br/><br/>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
			">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
			</form>
		</footer>
	</div>
	<div id="post-box" class="center">

	</div>
</body>
</html>
<?php
	function printFlags($lang, $paramKeys, $paramValues, $languages)
	{
		foreach($languages as $key => $language)
		{
			$arrayUrl = array();					

			$arrayUrl[0] = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
		 	for($i = 0; $i < count($paramKeys); $i++)
				if($paramKeys[$i] !== 'lang')
		 			$arrayUrl[$paramKeys[$i]] = $paramValues[$i];
			$arrayUrl['lang'] = $language;
			
			echo CHtml::link(CHtml::image(Yii::app()->controller->module->assetsUrl . '/images/flags/' . $language . '.gif', $language								
				,array('class' => ($lang === $language ? 'selectedflag' : '')))
				,$arrayUrl);
		}
	}
?>