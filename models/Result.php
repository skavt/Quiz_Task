<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $quiz_name
 * @property int $correct_ans
 * @property int $min_correct_ans
 * @property int $question_count
 * @property int $created_at
 * @property int $created_by
 *
 * @property Quiz $quiz
 * @property User $createdBy
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

    public function behaviors()
    {
        return [
            'class' => BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'correct_ans', 'min_correct_ans', 'question_count', 'created_at', 'created_by'], 'integer'],
            [['quiz_name'], 'string', 'max' => 255],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'correct_ans' => 'Correct Answer',
            'min_correct_ans' => 'Min Correct Answer',
            'question_count' => 'Max Question',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::className(), ['id' => 'quiz_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
