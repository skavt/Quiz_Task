<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuizSearch represents the model behind the search form of `app\models\Quiz`.
 */
class ResultSearch extends Result
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'correct_ans', 'min_correct_ans', 'created_at'], 'integer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
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
        $query = Result::find();

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
            'quiz_id' => $this->quiz_id,
            'quiz_name' => $this->quiz_id,
            'correct_ans' => $this->correct_ans,
            'min_correct_ans' => $this->min_correct_ans,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->quiz_id]);

        return $dataProvider;
    }
}
