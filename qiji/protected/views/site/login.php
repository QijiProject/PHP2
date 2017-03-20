<?php
if(isset($model))
{
?>

<!-- form login -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'top-websites-cr-form')); ?>
 
    <?php echo $form->errorSummary($model); ?>
 
    <div class="row">
        <?php echo $form->label($model,'username'); ?>
        <?php echo $form->textField($model,'username', array('value'=>'test')) ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($model,'password'); ?>
        <?php echo $form->passwordField($model,'password', array('value'=>'test')) ?>
    </div>
 
    <!-- <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
    </div> -->
 
    <div class="row submit">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div>
<!-- form -->
<?php
}
?>






