<?php

namespace greeschenko\scud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SensorSearch extends Sensor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'id',
            ], 'integer'],
            [[
                'id',
                'created_at',
                'updated_at',
                'user_id',
                'sn',
                'fw',
                'conn_fw',
                'active',
                'mode',
                'controller_ip',
            ], 'safe'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Sensor::find();

        // add conditions that should always apply here
        //$query->where(['!=', 'username', 'root']);
        //$query->orderBy('created_at DESC');
        /*$query->andWhere(['or',['role'=>'admin'],['or',['reg_as_org'=>1],['reg_as_member'=>1]]]);*/
        //if ($this->leader_id != '') {
            //$query->andWhere(['leader_id' => $this->leader_id]);
        //}

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'sn' => $this->sn,
            'fw' => $this->fw,
            'conn_fw' => $this->conn_fw,
            'active' => $this->active,
            'mode' => $this->mode,
            'controller_ip' => $this->controller_ip,
        ]);

        return $dataProvider;
    }
}
