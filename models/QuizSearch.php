<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quiz;

/**
 * QuizSearch represents the model behind the search form of `app\models\Quiz`.
 */
class QuizSearch extends Quiz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'min_correct_ans', 'max_questions',], 'integer'],
            [['subject', 'certification_valid'], 'safe'],
            [['created_at'], 'string']
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
        $query = Quiz::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        uncomment the following lines if you want to filter by created_at
//        if ($this->created_at) {
//            $query->andFilterWhere([
//                'FROM_UNIXTIME (created_at, "%Y-%m-%d")' => $this->created_at
//            ]);
//        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'min_correct_ans' => $this->min_correct_ans,
            'max_questions' => $this->max_questions,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject]);

        return $dataProvider;
    }
}
