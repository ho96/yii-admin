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
			Administration developed by <?= CHtml::link('http://oligalma.com', 'http://oligalma.com', array('target' => '_blank'))?>
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
