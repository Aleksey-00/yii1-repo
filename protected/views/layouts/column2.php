<div id="sidebar">
<?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => 'Операции',
    ));
$this->widget('zii.widgets.CMenu', array(
    'items' => $this->menu,
    'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
));
$this->endWidget();
?>
</div>