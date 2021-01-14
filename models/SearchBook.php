<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Modelbook;

/**
 * SearchBook represents the model behind the search form of `app\models\Modelbook`.
 */
class SearchBook extends Modelbook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_buku', 'tahun_terbit'], 'integer'],
            [['nama_buku', 'penerbit'], 'safe'],
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
        $query = Modelbook::find();

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
            'id_buku' => $this->id_buku,
            'tahun_terbit' => $this->tahun_terbit,
        ]);

        $query->andFilterWhere(['like', 'nama_buku', $this->nama_buku])
            ->andFilterWhere(['like', 'penerbit', $this->penerbit]);

        return $dataProvider;
    }
}
