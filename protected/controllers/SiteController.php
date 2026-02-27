<?php

class SiteController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            $this->render('error', $error);
        }
    }
}
