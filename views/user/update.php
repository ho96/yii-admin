<?php
	$userscript = "
		// Password strength meter
	    $('#User_repeatPassword, #User_password').pStrength({
	        'changeBackground'          : false,
	        'onPasswordStrengthChanged' : function(passwordStrength, strengthPercentage) {
	            if ($(this).val()) {
	                $.fn.pStrength('changeBackground', this, passwordStrength);
	            } else {
	                $.fn.pStrength('resetStyle', this);
	            }
	            $('#' + $(this).data('display')).html('(" . Yii::t('AdminModule.messages', 'profile.passwordstrength') . ": ' + strengthPercentage + '%)');
	        },
	    });
	    
	    // Password generator
		$.extend({
		  password: function (length, special) {
		    var iteration = 0;
		    var password = '';
		    var randomNumber;
		    if(special == undefined){
		        var special = false;
		    }
		    while(iteration < length){
		        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
		        if(!special){
		            if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
		            if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
		            if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
		            if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
		        }
		        iteration++;
		        password += String.fromCharCode(randomNumber);
		    }
		    return password;
		  }
		});
		
		$('#generatepasswordbutton').click(function(){
			var password = $.password(10,true);
			$('#generatepasswordtext').val(password);
			$('#User_password').val(password);
			$('#User_repeatPassword').val(password);
			$('#User_password').keyup();
			$('#User_repeatPassword').keyup();
		});
	";

	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile($this->module->assetsUrl.'/js/pStrength.jquery.js',CClientScript::POS_END);
	$cs->registerScript('userscript', $userscript);
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<?php echo CHtml::errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('style'=>'width:100%', 'autocomplete' => 'off')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'password', array('class' => 'left')); ?>
		<div style="margin-left:10px" class="left" id="pwdisplay"></div><div class="clear"></div>
		<?php echo CHtml::button(Yii::t('AdminModule.messages', 'profile.generatepassword'), array('id' => 'generatepasswordbutton')); ?>
		<?php echo CHtml::textField('','', array('id' => 'generatepasswordtext', 'style' => 'width:120px'))  ?>
		<div class="clear"></div>
		<?php echo $form->passwordField($model,'password',array('style'=>'width:100%', 'autocomplete' => 'off', 'data-display'=>'pwdisplay')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'repeatPassword', array('class' => 'left')); ?><div style="margin-left:10px" class="left" id="rpwdisplay"></div><div class="clear"></div>
		<?php echo $form->passwordField($model,'repeatPassword',array('style'=>'width:100%', 'autocomplete' => 'off', 'data-display'=>'rpwdisplay')); ?>
		<?php echo $form->error($model,'repeatPassword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('style'=>'width:100%', 'autocomplete' => 'off')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="center row buttons">
		<?php
		if(true):
		?>
		<?php 
			echo CHtml::submitButton(Yii::t('AdminModule.messages', 'common.save'));			
		?>
		<?php
		else:
		?>
			Submit button disabled in this demo.
		<?php
		endif;
		?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->