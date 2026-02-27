<?php
$this->breadcrumbs = array(
    'Книги' => array('index'),
    $model->title => array('view','id' => $model->id),
    'Редактирование',
);

$this->menu = array(
    array('label' => 'Список книг', 'url' => array('index')),
    array('label' => 'Создать книгу', 'url' => array('create')),
    array('label' => 'Посмотреть книгу', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Управление книгами', 'url' => array('admin')),
);
?>

<h1>Обновление книги <?php echo $model->id; ?></h1>

<?php $this->renderPartial(
    '_form',
    array(
        'model' => $model,
        'allAuthors' => $allAuthors,
    )); ?>