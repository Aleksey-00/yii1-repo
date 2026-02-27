<?php
/* @var $this BookController */
/* @var $authors array */
/* @var $year integer */

$this->pageTitle = "ТОП 10 авторов за " . $year . " год";
$this->breadcrumbs = array(
    'Книги' => array('index'),
    'ТОП-10 Авторов',
);
?>

<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="display-5 text-primary">🏆 ТОП 10 авторов</h1>
            <p class="text-muted">Рейтинг авторов по количеству выпущенных книг за выбранный год</p>
        </div>
        <div class="col-md-4">
            <form method="get" action="<?php echo $this->createUrl('book/top'); ?>" class="d-flex gap-2">
                <input type="number" name="year" value="<?php echo $year; ?>"
                       class="form-control form-control-lg shadow-sm"
                       min="1000" max="<?php echo date('Y') + 5; ?>">
                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Показать</button>
            </form>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4 py-3" style="width: 100px;">Место</th>
                    <th class="py-3">Автор (ФИО)</th>
                    <th class="text-center py-3" style="width: 250px;">Книг за <?php echo $year; ?> г.</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($authors)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                За <?php echo $year; ?> год данных о выпущенных книгах не найдено.
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($authors as $index => $row): ?>
                        <tr class="<?php echo ($index < 3) ? 'table-warning font-weight-bold' : ''; ?>">
                            <td class="ps-4">
                                <span class="badge rounded-pill <?php echo ($index < 3) ? 'bg-warning text-dark' : 'bg-secondary'; ?> fs-6">
                                    # <?php echo $index + 1; ?>
                                </span>
                            </td>
                            <td class="align-middle fs-5">
                                <strong><?php echo CHtml::encode($row['fio']); ?></strong>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-primary fs-6 py-2 px-3">
                                    <?php echo (int)$row['book_count']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 text-center">
    <?php echo CHtml::link('← Вернуться в каталог', array('book/index'), array('class' => 'btn btn-link text-decoration-none')); ?>
</div>

<?php if (Yii::app()->user->isGuest): ?>
    <?php
       $this->renderPartial('/subscription/_form', [
           'dataList' => CHtml::listData($authors, 'id', 'fio')
       ]);
    ?>
<?php endif; ?>