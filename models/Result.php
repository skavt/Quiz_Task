<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $quiz_name
 * @property int $min_correct_ans
 * @property int $question_count
 * @property int $created_at
 * @property string $created_by
 * @property int $correct_ans
 *
 * @property Quiz $quiz
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'min_correct_ans', 'question_count', 'created_at', 'correct_ans'], 'integer'],
            [['quiz_name'], 'string', 'max' => 255],
            [['created_by'], 'string', 'max' => 50],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'quiz_name' => 'Quiz Name',
            'min_correct_ans' => 'Min Correct Ans',
            'question_count' => 'Question Count',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'correct_ans' => 'Correct Ans',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }
}
