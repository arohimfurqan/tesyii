<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EventTools;

/**
 * SearchEventTools represents the model behind the search form of `app\models\EventTools`.
 */
class SearchEventTools extends EventTools
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'event_id', 'quantity'], 'integer'],
            [['nama_event'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EventTools::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'event_id' => $this->event_id,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'nama_event', $this->nama_event]);

        return $dataProvider;
    }
}
