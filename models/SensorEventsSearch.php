<?php

namespace greeschenko\scud\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SensorEventsSearch extends SensorEvents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'created_at',
                'updated_at',
                'event',
                'flag',
                'card',
                'time',
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
        $query = static::find();

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
            'event' => $this->event,
            'flag' => $this->flag,
            'card' => $this->card,
            'time' => $this->time,
        ]);

        return $dataProvider;
    }
}
