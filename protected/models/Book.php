<?php

/**
 * @property integer $id
 * @property string $title
 * @property integer $year
 * @property string $description
 * @property string $isbn
 * @property string $image
 * @property Author[] $authors
 */
class Book extends CActiveRecord
{
    public $authorIds = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'book';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title, year, isbn', 'required'),
            array('year', 'numerical', 'integerOnly' => true),
            array('title, isbn, image', 'length', 'max' => 255),
            array('description', 'safe'),
            array('id, title, year, description, isbn, image', 'safe', 'on' => 'search'),
            array('authorIds', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'Isbn',
            'image' => 'Картинка',
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('year', $this->year);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('isbn', $this->isbn, true);
        $criteria->compare('image', $this->image, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Book the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            $authorIds = is_array($this->authors) ? $this->authors : [];

            if (!empty($authorIds)) {
                $subscribers = Yii::app()->db->createCommand()
                    ->selectDistinct('phone')
                    ->from('subscriptions')
                    ->where(['in', 'author_id', $authorIds])
                    ->queryColumn();

                $sms = new SmsService();
                foreach ($subscribers as $phone) {
                    $message = "Вышла новая книга: " . $this->title;
                    $sms->send($phone, $message);
                }
            }
        }
    }

    protected function afterFind()
    {
        parent::afterFind();
        foreach ($this->authors as $author) {
            $this->authorIds[] = $author->id;
        }
    }

    public function getSelectedAuthors()
    {
        $ids = array();
        if (!empty($this->authors)) {
            foreach ($this->authors as $author) {
                $ids[] = $author->id;
            }
        }
        return $ids;
    }

    protected function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->image) {
            $filePath = Yii::getPathOfAlias('webroot') . '/uploads/' . $this->image;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        BookAuthor::model()->deleteAllByAttributes(array('book_id' => $this->id));

        return true;
    }
}
