<?php

class BookController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    /**
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
                array('allow',
                    'actions' => array('index', 'view', 'top', 'subscribe'),
                    'users' => array('*'),
                ),
                array('allow',
                    'actions' => array('create', 'update', 'admin', 'delete'),
                    'users' => array('@'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
        );
    }

    /**
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Book();
        $allAuthors = Author::model()->findAll();

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $file = CUploadedFile::getInstance($model, 'image');
            $authorIds = isset($_POST['authorIds']) && is_array($_POST['authorIds']) ? $_POST['authorIds'] : array();

            if ($model->validate()) {
                try {
                    $service = new BookService();
                    $service->create($model, $file, $authorIds);
                    $this->redirect(array('view', 'id' => $model->id));
                } catch (Exception $e) {
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'allAuthors' => $allAuthors,
        ));
    }

    /**
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $allAuthors = Author::model()->findAll();

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];

            $file = CUploadedFile::getInstance($model, 'image');
            $authorIds = isset($_POST['authorIds']) && is_array($_POST['authorIds']) ? $_POST['authorIds'] : array();

            if ($model->validate()) {
                try {
                    $service = new BookService();
                    $service->update($model, $file, $authorIds);
                    $this->redirect(array('view', 'id' => $model->id));
                } catch (Exception $e) {
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'allAuthors' => $allAuthors,
        ));
    }

    /**
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {

            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Некорректный запрос. Удаление возможно только через POST.');
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Book');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }


    public function actionAdmin()
    {
        $model = new Book('search');
        $model->unsetAttributes();
        if (isset($_GET['Book'])) {
            $model->attributes = $_GET['Book'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param integer $id the ID of the model to be loaded
     * @return Book the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Book::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param Book $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'book-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTop($year = null)
    {
        if ($year === null) {
            $year = (int)date('Y');
        } else {
            $year = (int)$year;
        }

        $repository = new AuthorRepository();
        $authors = $repository->getTopAuthorsByYear($year);

        $this->render('top', array(
            'authors' => $authors,
            'year' => $year,
        ));
    }
}
