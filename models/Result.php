<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "result".
 *
 * @property int $id
 * @property string $quiz_name
 * @property int $correct_ans
 * @property int $min_correct_ans
 * @property int $question_count
 * @property string $certification_valid
 * @property int $created_at
 * @property int $created_by
 *
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
            [['correct_ans', 'min_correct_ans', 'question_count', 'created_at', 'created_by'], 'integer'],
            [['certification_valid'], 'safe'],
            [['quiz_name'], 'string', 'max' => 255],
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
            'quiz_name' => 'Quiz Name',
            'correct_ans' => 'Correct Answer',
            'min_correct_ans' => 'Min Correct Answer',
            'question_count' => 'Question Count',
            'status' => 'Status',
            'percentage' => 'Percentage',
            'certification_valid' => 'Certification Status',
            'created_at' => 'Passed At',
            'created_by' => 'Passed By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
