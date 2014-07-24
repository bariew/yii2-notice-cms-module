<?php

namespace bariew\noticeModule\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemSearch represents the model behind the search form about `bariew\noticeModule\models\Item`.
 */
class ItemSearch extends Item
{
    public function rules()
    {
        return [
            [['id', 'owner_id', 'type', 'status', 'created_at'], 'integer'],
            [['address', 'title', 'content', 'owner_name', 'owner_event'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Item::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'owner_event', $this->owner_event]);

        return $dataProvider;
    }
}
