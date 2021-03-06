<?php

namespace ityakutia\collective\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class CollectiveSearch extends Collective
{
    public function rules()
    {
        return [
            [['id', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'photo', 'post', 'phone', 'email', 'vk_link', 'fb_link', 'inst_link'], 'safe']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Collective::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,

            'sort' => $this->sort,
            'is_publish' => $this->is_publish,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'vk_link', $this->vk_link])
            ->andFilterWhere(['like', 'fb_link', $this->fb_link])
            ->andFilterWhere(['like', 'inst_link', $this->inst_link])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'post', $this->post])
            ->andFilterWhere(['like', 'photo', $this->photo])
        ;

        return $dataProvider;
    }
}
