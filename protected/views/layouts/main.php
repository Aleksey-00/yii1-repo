<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <style>
        body { padding-top: 80px; background-color: #f4f7f6; }
        .main-container { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav-link.active { font-weight: bold; border-bottom: 2px solid #fff; }
        .breadcrumb { padding: 10px 0; margin-bottom: 20px; background: none;
        }
        .breadcrumb a,
        .breadcrumb span {
            display: inline-block;
            margin-right: 8px;
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb a:after,
        .breadcrumb span:not(:last-child):after {
            content: "/";
            margin-left: 8px;
            color: #dee2e6;
        }

        .breadcrumb span:last-child {
            color: #212529;
            font-weight: 500;
        }

        label .required {
            color: #dc3545 !important;
            font-weight: bold;
            margin-left: 2px;
        }

        .error label {
            color: #dc3545;
        }
        .row > * {
            padding-left: 0px;
        }

        table.detail-view th {
            text-align: left;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo Yii::app()->baseUrl; ?>/">📚 BookCatalog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Каталог', 'url' => array('/book/index'), 'linkOptions' => array('class' => 'nav-link')),
                    array('label' => 'ТОП-10 Авторов', 'url' => array('/book/top'), 'linkOptions' => array('class' => 'nav-link')),
                    array('label' => 'Вход', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array('class' => 'nav-link')),
                    array('label' => 'Выход ('.Yii::app()->user->name.')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array('class' => 'nav-link')),
                ),
                'htmlOptions' => array('class' => 'navbar-nav ms-auto'),
            )); ?>
        </div>
    </div>
</nav>

<div class="container main-container">
    <?php if (isset($this->breadcrumbs)):?>
        <nav aria-label="breadcrumb">
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'homeLink' => CHtml::link('Главная', Yii::app()->homeUrl),
                'htmlOptions' => array('class' => 'breadcrumb'),
                'separator' => '',
            )); ?>
        </nav>
    <?php endif?>

    <?php echo $content; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>