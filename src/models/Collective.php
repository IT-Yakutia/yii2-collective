<?php

namespace ityakutia\collective\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;
use creocoder\nestedsets\NestedSetsBehavior;

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
            ],
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CollectiveQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position'], 'default', 'value' => 0],
            [['tree', 'sort', 'lft', 'rgt', 'depth', 'position', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'photo', 'post', 'phone', 'email', 'vk_link', 'fb_link', 'inst_link'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'photo' => 'Фото',
            'post' => 'Должность',
            'phone' => 'Телефон',
            'email' => 'Email',
            'vk_link' => 'Ссылка VK',
            'fb_link' => 'Ссылка Facebook',
            'inst_link' => 'Ссылка Instagram',

            'tree' => 'Иерархия',
            'lft' => 'Left',
            'rgt' => 'Right',
            'depth' => 'Depth',
            'position' => 'Позиция в списке',

            'sort' => 'Sort',
            'is_publish' => 'Опубликовать',
            'status' => 'Status',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
        ];
    }

    /**
     * Get parent's ID
     * @return \yii\db\ActiveQuery 
     */
    public function getParentId()
    {
        $parent = $this->parent;
        return $parent ? $parent->id : null;
    }

    /**
     * Get parent's node
     * @return \yii\db\ActiveQuery 
     */
    public function getParent()
    {
        return $this->parents(1)->one();
    }

    /**
     * Get a full tree as a list, except the node and its children
     * @param  integer $node_id node's ID
     * @return array array of node
     */
    public static function getTree($node_id = 0)
    {
        // don't include children and the node
        $children = [];

        if (!empty($node_id))
            $children = array_merge(
                self::findOne($node_id)->children()->column(),
                [$node_id]
            );

        $rows = self::find()
            ->select('id, name, depth')
            ->where(['NOT IN', 'id', $children])
            ->orderBy('tree, lft, position')
            ->all();

        $return = [];
        foreach ($rows as $row)
            $return[$row->id] = str_repeat('-', $row->depth) . ' ' . $row->name;

        return $return;
    }

    public function getTreesList()
    {
        return $this->find()->select('tree')->asArray()->all();
    }
}
