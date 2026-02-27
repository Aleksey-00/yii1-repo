<?php
/* @var $this BookController */
/* @var $data Book */
?>

<div class="panel panel-default">
    <div class="panel-body">
        <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
        <?php echo CHtml::encode($data->title); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
        <?php echo CHtml::encode($data->year); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
        <?php echo CHtml::encode($data->description); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('isbn')); ?>:</b>
        <?php echo CHtml::encode($data->isbn); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
        <?php echo CHtml::encode($data->image); ?>
        <br />
    </div>
</div>