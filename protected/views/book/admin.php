<?php
$this->breadcrumbs = array(
    'Книги' => array('index'),
    'Управление',
);

$this->menu = array(
    array('label' => 'Список книг', 'url' => array('index')),
    array('label' => 'Создание книги', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#book-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление книгами</h1>

<p>
Вы можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> или <b>=</b>)
в начале каждого значения поиска для уточнения результатов.
</p>

<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button btn btn-outline-secondary mb-3')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'book-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'summaryText' => 'Отображено {start}-{end} из {count} записей.',
    'emptyText' => 'Ничего не найдено.',
    'columns' => array(
        'id',
        'title',
        'year',
        'description',
        'isbn',
        'image',
        array(
            'class' => 'CButtonColumn',
            'header' => 'Управление',
            'deleteConfirmation' => "Вы уверены, что хотите удалить эту книгу?\nФайл обложки также будет удален с сервера.",
            'afterDelete' => 'function(link,success,data){ if(success) alert("Книга успешно удалена"); }',
            'buttons' => array(
                            'view' => array('label' => '👀'),
                            'update' => array('label' => '✏️'),
                            'delete' => array(
                                'label' => '🗑️',
                            ),
                        ),
        ),
    ),
)); ?>
