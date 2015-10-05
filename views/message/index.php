<?php $this->renderPartial('/message/_selectors',array(
	'languages'=>$languages,
	'files'=>$files,
	'language'=>$language,
	'file'=>$file,
)); ?>
<div id="messages-content">
<table id="messages-table">
	<?php	 
	foreach($fileKeys as $index => $key):
	?>
	<tr>
		<td><?= CHtml::link(Yii::t('AdminModule.messages', 'common.edit'), array('message/edit', 'language' => $language, 'file' => $file, 'message-id' => $index, 'lang' => Yii::app()->language)) ?></td>
		<td><?= $key ?></td>
		<td><?= substr($fileValues[$index],0,200) ?><?= (strlen($fileValues[$index]) > 200 ? '...' : '') ?></td>
	</tr>
	<?php
	endforeach;
	?>
</table>
</div>