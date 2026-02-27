<?php
/* @var $this AuthorController */
/* @var $model Author */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'author-form',
    'enableAjaxValidation' => false,
)); ?>

	<p class="note">Поля обязательны  <span class="text-danger">*</span> для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'fio'); ?>
		<?php echo $form->textField($model, 'fio', array('size' => 60,'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'fio'); ?>
	</div>

	<div class="row buttons mt-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>