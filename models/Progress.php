<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "progress".
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $question_id
 * @property int $selected_answer
 * @property int $is_correct
 * @property int $last_question
 * @property int $created_at
 * @property int $created_by
 *
 * @property User $createdBy
 */
class Progress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'progress';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'question_id', 'selected_answer', 'is_correct', 'last_question', 'created_at', 'created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function insertData()
    {
        $data = Yii::$app->request->post();

        if ($data['selected_answer'] == null) {
            $this->is_correct = null;
        } else {
            $answers = Answer::find()->where(['id' => $data['selected_answer']])->one();
            $this->is_correct = $answers->is_correct;
        }

        $this->quiz_id = $data['quiz_id'];
        $this->question_id = $data['question_id'];
        $this->selected_answer = $data['selected_answer'];
//        $this->last_question = $data['last_question'];
        $this->created_at = time();

        $this->save();

        $this->created_by = function () {
            return $this->createdBy->id;
        };

    }

    public function outcomeData()
    {
        $countCorrectAnswer = Progress::find()
            ->where(['is_correct' => true])
            ->count();

        $countQuestion = Progress::find()->count();

        return [
            'countCorrectAnswer' => $countCorrectAnswer,
            'countQuestion' => $countQuestion,
        ];
    }

    public function progressData()
    {
        $model = Progress::find()->all();
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'question_id' => 'Question ID',
            'selected_answer' => 'Selected Answer',
            'is_correct' => 'Is Correct',
            'last_question' => 'Last Question',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
