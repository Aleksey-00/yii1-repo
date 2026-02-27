<?php
/* @var $this AuthorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Авторы',
);

$this->menu = array(
    array('label' => 'Добавить Автора', 'url' => array('create')),
    array('label' => 'Управление Авторами', 'url' => array('admin')),
);
?>

<h1>Авторы</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'summaryText' => 'Показано {start}-{end} из {count} авторов.',
    'emptyText' => 'В каталоге пока нет ни одного автора.',
    'pager' => array(
            'header' => 'Перейти к странице: ',
            'nextPageLabel' => 'Вперед',
            'prevPageLabel' => 'Назад',
    ),
)); ?>
