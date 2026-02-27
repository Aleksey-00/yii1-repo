<?php

/**
 * This is the model class for table "author".
 *
 * The followings are the available columns in table 'author':
 * @property integer $id
 * @property string $fio
 *
 * The followings are the available model relations:
 * @property Book[] $books
 * @property Subscription[] $subscriptions
 */
class Author extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'author';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array('fio', 'required'),
            array('fio', 'length', 'max' => 255),
            array('id, fio', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'books' => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'),
            'subscriptions' => array(self::HAS_MANY, 'Subscription', 'author_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'id',
            'fio' => 'ФИО',
        );
    }

    /**
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('fio', $this->fio, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param string $className active record class name.
     * @return Author the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
