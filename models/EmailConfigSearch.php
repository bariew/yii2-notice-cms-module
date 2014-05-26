<?php

namespace app\modules\notice\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\notice\models\EmailConfig;

/**
 * EmailConfigSearch represents the model behind the search form about `app\modules\notice\models\EmailConfig`.
 */
class EmailConfigSearch extends EmailConfig
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'subject', 'content', 'owner_name', 'owner_event'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EmailConfig::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'owner_event', $this->owner_event]);

        return $dataProvider;
    }
}
