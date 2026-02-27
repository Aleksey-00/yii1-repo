<div class="sub-form" style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h5>Уведомлять меня о новых книгах автора по SMS</h5>

    <?php if (Yii::app()->user->hasFlash('success')): ?>
         <div style="color: green;"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php elseif (Yii::app()->user->hasFlash('error')): ?>
         <div style="color: red;"><?php echo Yii::app()->user->getFlash('error'); ?></div>
    <?php endif; ?>

    <?php $form = $this->beginWidget('CActiveForm', [
         'action' => Yii::app()->createUrl('subscription/create'),
    ]); ?>
         <?php $sub = new Subscription(); ?>

         <label>Автор:</label><br>
          <?php echo $form->dropDownList($sub, 'author_id', $dataList); ?>
          <br>
          <label>Телефон (79991112233):</label><br>
          <?php echo $form->textField($sub, 'phone'); ?>
          <?php echo CHtml::submitButton('Подписаться'); ?>
        <?php $this->endWidget(); ?>
</div>
