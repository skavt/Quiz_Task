<?php


namespace app\models;


use yii\base\Model;
use yii\helpers\VarDumper;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            [['username'], 'string', 'min' => 4, 'max' => 55],
            [['password', 'password_repeat', 'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20}'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->access_token = \Yii::$app->security->generateRandomString();

        if ($user->save()) {
            return true;
        }

        \Yii::error('User does not saved.' . VarDumper::dumpAsString($user->errors));
        return false;

    }

}


