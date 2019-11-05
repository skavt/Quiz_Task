<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $question_id
 * @property int $is_correct
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Question $question
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
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
            [['question_id', 'name'], 'required'],
            [['question_id', 'is_correct', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            ['is_correct', 'correctAnswerValidator', 'on' => 'create'],
            ['is_correct', 'incorrectAnswerValidator', 'on' => 'create'],
        ];
    }

    public function correctAnswerValidator($attribute)
    {
        $correctAnsCount = Answer::find()
            ->where(['question_id' => $this->question_id, 'is_correct' => true])
            ->count();

        if ($correctAnsCount == 1 && $this->is_correct == 1) {
            $this->addError($attribute, 'You have already chosen correct answer');
        }

    }

    public function incorrectAnswerValidator($attribute)
    {
        $incorrectAnsCount = Answer::find()
            ->where([
                'question_id' => $this->question_id,
                'is_correct' => false
            ])
            ->count();

        $question = Question::find()
            ->where(['id' => $this->question_id])
            ->one();

        if ($this->is_correct == 0 && $incorrectAnsCount == $question->max_ans - 1) {
            $this->addError($attribute, 'You can\'t choose another incorrect answer');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'is_correct' => 'Is Correct',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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

    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}