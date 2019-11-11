<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "progress".
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $question_id
 * @property string $selected_answer
 * @property int $is_correct
 * @property int $last_question
 * @property int $created_at
 * @property int $passed_by
 *
 * @property Question $question
 * @property Quiz $quiz
 * @property User $passedBy
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'question_id', 'is_correct', 'last_question', 'created_at', 'passed_by'], 'integer'],
            [['selected_answer'], 'string', 'max' => 255],
            [['passed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['passed_by' => 'id']],
        ];
    }

    public function insertData()
    {
        $data = Yii::$app->request->post();
        $answers = Answer::find()->where(['name' => $data['selected_answer']])->one();

        $this->quiz_id = $data['quiz_id'];
        $this->question_id = $data['question_id'];
        $this->selected_answer = $data['selected_answer'];
        $this->is_correct = $answers->is_correct;
        $this->last_question = $data['last_question'];
        $this->created_at = time();

        $this->save();
    }

//    public function progressData()
//    {
//        $model = Progress::find()->all();
//        return $model;
//    }

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
            'passed_by' => 'Passed By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPassedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'passed_by']);
    }
}
