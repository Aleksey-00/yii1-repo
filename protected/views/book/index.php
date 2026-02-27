<?php
$this->breadcrumbs = array('Книги');
?>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="mb-3">
        <?php echo CHtml::link('➕ Добавить книгу', array('create'), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link('⚙️ Управление', array('admin'), array('class' => 'btn btn-primary')); ?>
    </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'emptyText' => '<div class="alert alert-info">Книг пока нет.</div>',
    'summaryText' => 'Показано {start}-{end} из {count}',
    'pager' => array(
        'header' => '',
        'selectedPageCssClass' => 'active',
        'internalPageCssClass' => '',
        'htmlOptions' => array('class' => 'pagination'),
    ),
)); ?>
