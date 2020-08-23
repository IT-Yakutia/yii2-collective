<?php

namespace ityakutia\collective\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;

class Collective extends ActiveRecord
{
    public static function tableName()
    {
        return 'collective';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'sortable' => [
                'class' => Sortable::class,
                'query' => self::find(),
            ]
        ];
    }

    public function rules()
    {
        return [
            [['name', 'photo'], 'required'],
            [['parent_id', 'sort', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'photo', 'position', 'phone', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'photo' => 'Фото',
            'position' => 'Должность',
            'phone' => 'Телефон',
            'email' => 'Email',

            'parent_id' => 'Подчиняется',

            'sort' => 'Sort',
            'is_publish' => 'Опубликовать',
            'status' => 'Status',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    public function getParent()
    {
        if(empty($this->parent)) {
            return false;
        }

        return self::find()->where(['id' => $this->parent_id])->one();
    }

    public function getForParent()
    {
        return self::find()->where(['id', '!=', $this->id])->all();
    }
}
