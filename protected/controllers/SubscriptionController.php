<?php

class SubscriptionController extends Controller
{
    public function filters()
    {
        return ['accessControl'];
    }

    public function accessRules()
    {
        return [
            ['allow', 'users' => ['*']],
        ];
    }

    public function actionCreate()
    {
        $model = new Subscription();

        if (isset($_POST['Subscription'])) {
            $model->attributes = $_POST['Subscription'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Вы успешно подписались на уведомления!');
            } else {
                $errors = array_values($model->getErrors());
                Yii::app()->user->setFlash('error', $errors[0][0]);
            }
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}
