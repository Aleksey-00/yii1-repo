<?php

$this->breadcrumbs = array(
    'Книги' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'Список книг', 'url' => array('index')),
    array('label' => 'Добавить книгу', 'url' => array('create')),
    array('label' => 'Редактировать книгу', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Удалить книгу', 'url' => '#', 'linkOptions' => array('submit' => array('delete','id' => $model->id),'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Управление книгами', 'url' => array('admin')),
);
?>

<h1>Книга #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'htmlOptions' => array('class' => 'table table-striped table-bordered shadow-sm'),
    'attributes' => array(
        'id',
        'title',
        'year',
        'isbn',
        'description:ntext',
        array(
            'name' => 'image',
            'type' => 'html',
            'value' => $model->image
                ? CHtml::image(Yii::app()->baseUrl . '/uploads/' . $model->image, 'Обложка', array(
                    'class' => 'img-thumbnail shadow-sm',
                    'style' => 'max-width: 300px;'
                  ))
                : '<span class="text-muted">Фото не загружено</span>',
        ),
        array(
            'label' => 'Авторы',
            'type' => 'raw',
            'value' => function ($data) {
                $list = array();
                foreach ($data->authors as $author) {
                    $list[] = CHtml::encode($author->fio);
                }
                return $list ? implode(', ', $list) : '<span class="text-danger">Автор не указан</span>';
            },
        ),
    ),
)); ?>

<?php if (Yii::app()->user->isGuest): ?>
    <?php
        $this->renderPartial('/subscription/_form', [
            'dataList' => CHtml::listData($model->authors, 'id', 'fio')
        ]);
    ?>
<?php endif; ?>
