<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransaksiDetil;

/**
 * TransaksiDetilSearch represents the model behind the search form of `app\models\TransaksiDetil`.
 */
class TransaksiDetilSearch extends TransaksiDetil
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'transaksi_id', 'obat_id', 'qty'], 'integer'],
            [['harga_jual'], 'number'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = TransaksiDetil::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'transaksi_id' => $this->transaksi_id,
            'obat_id' => $this->obat_id,
            'harga_jual' => $this->harga_jual,
            'qty' => $this->qty,
        ]);

        return $dataProvider;
    }
}
