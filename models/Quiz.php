<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quiz".
 *
 * @property int $id
 * @property string $subject
 * @property int $min_correct_ans
 * @property int $max_questions
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Question[] $questions
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'min_correct_ans'], 'required'],
            [['min_correct_ans', 'max_questions', 'created_at', 'updated_at'], 'integer'],
            [['subject'], 'string', 'max' => 127],
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,

            'class' => BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'min_correct_ans' => 'Min Correct Ans',
            'max_questions' => 'Max Questions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['quiz_id' => 'id']);
    }
}
