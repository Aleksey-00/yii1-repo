<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
/* @var $allAuthors Author[] */
?>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'book-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'needs-validation'),
        )); ?>

        <p class="text-muted mb-4">Поля с <span class="text-danger">*</span> обязательны для заполнения.</p>

        <?php echo $form->errorSummary($model, null, null, array('class' => 'alert alert-danger')); ?>

        <div class="row">
            <div class="col-lg-8 border-end pe-lg-4">

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'title', array('class' => 'form-label')); ?>
                    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Введите название книги')); ?>
                    <?php echo $form->error($model, 'title', array('class' => 'text-danger small')); ?>
                </div>

                <div class="row g-1">
                    <div class="col-md-6 mb-3">
                        <?php echo $form->labelEx($model, 'year', array('class' => 'form-label')); ?>
                        <?php echo $form->numberField($model, 'year', array('class' => 'form-control', 'placeholder' => 'Напр: 2024')); ?>
                        <?php echo $form->error($model, 'year', array('class' => 'text-danger small')); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?php echo $form->labelEx($model, 'isbn', array('class' => 'form-label')); ?>
                        <?php echo $form->textField($model, 'isbn', array('class' => 'form-control', 'placeholder' => '978-3-16...')); ?>
                        <?php echo $form->error($model, 'isbn', array('class' => 'text-danger small')); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'description', array('class' => 'form-label')); ?>
                    <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'rows' => 6, 'placeholder' => 'Краткое описание книги...')); ?>
                    <?php echo $form->error($model, 'description', array('class' => 'text-danger small')); ?>
                </div>
            </div>

            <div class="col-lg-4 ps-lg-4 mt-4 mt-lg-0">

                <div class="mb-4">
                    <?php echo $form->labelEx($model, 'image', array('class' => 'form-label fw-bold')); ?>
                    <div class="input-group">
                        <?php echo $form->fileField($model, 'image', array('class' => 'form-control')); ?>
                    </div>
                    <small class="text-muted d-block mt-1">Фото главной страницы</small>
                    <?php echo $form->error($model, 'image', array('class' => 'text-danger small')); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Авторы</label>

                    <?php if (empty($allAuthors)): ?>
                        <div class="alert alert-warning text-center py-3">
                            <p class="small mb-2">Авторов пока нет.</p>
                            <?php echo CHtml::link('➕ Добавить автора', array('author/create'), array('class' => 'btn btn-xs btn-outline-primary btn-sm')); ?>
                        </div>
                    <?php else: ?>
                        <div class="border rounded bg-light p-3" style="max-height: 250px; overflow-y: auto;">
                            <?php echo CHtml::checkBoxList('authorIds', $model->getSelectedAuthors(),
                                CHtml::listData($allAuthors, 'id', 'fio'),
                                array(
                                    'template' => '<div class="form-check mb-2">{input} {label}</div>',
                                    'separator' => '',
                                    'class' => 'form-check-input',
                                    'labelOptions' => array('class' => 'form-check-label'),
                                )
                            ); ?>
                        </div>
                        <p class="text-muted small mt-2 italic">* Книга может иметь несколько авторов</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row mt-4 pt-3 border-top">
            <div class="col-12">
                <?php echo CHtml::submitButton($model->isNewRecord ? '➕ Добавить книгу в каталог' : '💾 Сохранить изменения', array('class' => 'btn btn-success btn-lg px-5')); ?>
                <?php echo CHtml::link('Отмена', array('index'), array('class' => 'btn btn-link text-secondary')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>