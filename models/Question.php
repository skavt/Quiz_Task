<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $name
 * @property string $hint
 * @property int $max_ans
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Answer[] $answers
 * @property Quiz $quiz
 * @property User $createdBy
 * @property User $updatedBy
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'name', 'max_ans'], 'required'],
            [['quiz_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'hint'], 'string', 'max' => 255],
            [['max_ans'], 'integer', 'min' => 2, 'max' => 6],
            ['max_ans', 'validateMaxAnswer'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::className(), 'targetAttribute' => ['quiz_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function validateMaxAnswer($attribute)
    {
        $countAnswer = Answer::find()->where(['question_id' => $this->id])->count();

        if ($countAnswer > $this->max_ans) {
            $this->addError($attribute, 'Your answers is more than that Max answer');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz_id' => 'Quiz ID',
            'name' => 'Name',
            'hint' => 'Hint',
            'max_ans' => 'Max Answer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
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

    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
