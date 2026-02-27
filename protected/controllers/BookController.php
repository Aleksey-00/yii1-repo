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

            if ($file) {
                $fileName = time() . '_' . uniqid() . '_' . $file->name;
                $model->image = $fileName;
            }

            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                $path = Yii::getPathOfAlias('webroot') . '/uploads/';

                try {
                    if ($model->save(false)) {
                        if ($file) {
                            if (file_exists($path . $fileName)) {
                                unlink($path . $fileName);
                            }

                            if (!$file->saveAs($path . $fileName)) {
                                throw new Exception("Не удалось сохранить файл на диск");
                            }
                        }

                        if (isset($_POST['authorIds']) && is_array($_POST['authorIds'])) {
                            foreach (array_unique($_POST['authorIds']) as $authorId) { // array_unique защитит от дублей в POST
                                $ba = new BookAuthor();
                                $ba->book_id = $model->id;
                                $ba->author_id = (int)$authorId;
                                if (!$ba->save()) {
                                    throw new Exception("Ошибка связи с автором");
                                }
                            }
                        }

                        $transaction->commit();
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                } catch (Exception $e) {
                    if ($transaction->active) {
                        $transaction->rollback();
                    }


                    if ($file && file_exists($path . $fileName)) {
                        unlink($path . $fileName);
                    }

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
        $oldImage = $model->image;

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];


            $file = CUploadedFile::getInstance($model, 'image');
            if ($file) {
                $fileName = bin2hex(random_bytes(8)) . '.' . $file->extensionName;
                $model->image = $fileName;
            } else {
                $model->image = $oldImage;
            }

            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {

                    if ($file) {
                        $path = Yii::getPathOfAlias('webroot') . '/uploads/';
                        if ($oldImage && file_exists($path . $oldImage)) {
                            unlink($path . $oldImage);
                        }
                        $file->saveAs($path . $fileName);
                    }


                    BookAuthor::model()->deleteAllByAttributes(array('book_id' => $model->id));
                    if (isset($_POST['authorIds']) && is_array($_POST['authorIds'])) {
                        foreach (array_unique($_POST['authorIds']) as $authorId) {
                            $ba = new BookAuthor();
                            $ba->book_id = $model->id;
                            $ba->author_id = (int)$authorId;
                            if (!$ba->save()) {
                                throw new Exception("Ошибка сохранения связи");
                            }
                        }
                    }

                    $transaction->commit();
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) {
                if ($transaction->active) {
                    $transaction->rollback();
                }
                Yii::app()->user->setFlash('error', $e->getMessage());
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

    public function actionTop($year = 1991)
    {
        $year = $year ? (int)$year : (int)date('Y');

        $sql = "SELECT a.id, a.fio, COUNT(ba.book_id) as book_count
                FROM author a
                INNER JOIN book_author ba ON a.id = ba.author_id
                INNER JOIN book b ON ba.book_id = b.id
                WHERE b.year = :year
                GROUP BY a.id
                ORDER BY book_count DESC
                LIMIT 10";

        $authors = Yii::app()->db->createCommand($sql)->queryAll(true, array(':year' => $year));

        $this->render('top', array(
            'authors' => $authors,
            'year' => $year
        ));
    }
}
