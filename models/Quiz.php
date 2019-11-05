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
 * @property string $certification_valid
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Question[] $questions
 * @property User $updatedBy
 * @property User $createdBy
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
            [['subject', 'min_correct_ans', 'certification_valid', 'max_questions'], 'required'],
            [['min_correct_ans', 'max_questions', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['certification_valid'], 'safe'],
            [['min_correct_ans'], 'integer', 'min' => 1],
            [['max_questions'], 'integer', 'min' => 2],
            [['subject'], 'string', 'max' => 127],
            ['max_questions', 'compare', 'compareAttribute' => 'min_correct_ans', 'operator' => '>=', 'type' => 'number'],
            ['max_questions', 'maxQuestionValidator'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function maxQuestionValidator($attribute)
    {
        $countQuestion = Question::find()
            ->where(['quiz_id' => $this->id])
            ->count();

        if ($countQuestion > $this->max_questions) {
            $this->addError($attribute, 'Your questions is more than that Max question');
        }
    }

    public function startQuizQuestionValidation()
    {
        $countQuestion = Question::find()
            ->where(['quiz_id' => $this->id])
            ->count();

        if ($countQuestion < $this->min_correct_ans) {
            return true;
        }
    }

    public function startQuizAnswerValidation()
    {

        $questionModel = Question::find()
            ->where(['quiz_id' => $this->id])
            ->all();

        foreach ($questionModel as $question) {
            $countAllAnswer = Answer::find()
                ->where(['question_id' => $question->id])
                ->count();
            $countIncorrectAnswer = Answer::find()
                ->where(['question_id' => $question->id, 'is_correct' => false])
                ->count();
            $countCorrectAnswer = Answer::find()
                ->where(['question_id' => $question->id, 'is_correct' => true])
                ->count();

            if ($countAllAnswer <= 1 || $countIncorrectAnswer == $question->max_ans
                || $countCorrectAnswer != 1 || $countCorrectAnswer > 1) {
                return true . $question->name;
            }
        }
    }

    public function startQuiz()
    {
        $result = new Result();
        $countQuestion = Question::find()
            ->where(['quiz_id' => $this->id])
            ->count();

        if (Yii::$app->request->post()) {
            $response = Yii::$app->request->post();
            $answerIndex = 0;
            $correctAnswer = 0;
            $array = [];

            foreach ($response as $text => $answerId) {
                $select = substr($text, 0, 9);
                if ($select == 'selected_') {
                    $array[$answerIndex] = $answerId;
                    $answerIndex++;
                }
            }
            foreach ($array as $arr) {
                $answer = Answer::findOne($arr);
                if ($answer->is_correct == 1) {
                    $correctAnswer++;
                }
            }
            $result->correct_ans = $correctAnswer;
            $result->quiz_name = $this->subject;
            $result->question_count = $countQuestion;
            $result->min_correct_ans = $this->min_correct_ans;
            $result->created_at = time();
            $month = strtotime(" + $this->certification_valid months", $result->created_at);
            $result->certification_valid = $month;

            if (!$result->save()) {
                return [
                    'message' => 'Your result didn\'t save'
                ];
            }
            return $correctAnswer;
        }
    }

    public function dropDownList()
    {
        return range(1, 6);
    }

    /**
     * {@inheritdoc}
     */
    public
    function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'min_correct_ans' => 'Min Correct Answer',
            'max_questions' => 'Max Questions',
            'certification_valid' => 'Certification Valid (Month)',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public
    function getQuestions()
    {
        return $this->hasMany(Question::className(), ['quiz_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public
    function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public
    function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
