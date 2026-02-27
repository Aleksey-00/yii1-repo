<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs = array(
    'Авторы' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Список Авторов', 'url' => array('index')),
    array('label' => 'Добавить Автора', 'url' => array('create')),
    array('label' => 'Изменить Автора', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Удалить Автора', 'url' => '#', 'linkOptions' => array('submit' => array('delete','id' => $model->id),'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Управление Авторами', 'url' => array('admin')),
);
?>

<h1>Автор #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'fio',
    ),
)); ?>
