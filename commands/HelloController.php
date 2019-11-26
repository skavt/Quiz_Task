<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Progress;
use app\models\Quiz;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionProgress()
    {
        $progressModelId = Progress::find()->one()->quiz_id;
        $quizModel = Quiz::findAll(['id' => $progressModelId]);

        $progressCreatedTime = Progress::find()->one()->created_at;

        $quizTime = $quizModel[0]->quiz_time;
        $quizTimeFormat = $quizModel[0]->quiz_time_format;

        $lastTime = strtotime(" + $quizTime $quizTimeFormat", $progressCreatedTime);

        if (time() > $lastTime) {

            $progressModel = Progress::find()->all();
            $progressModel[0]->deleteAll(['quiz_id' => $quizModel[0]->id]);

        }
    }

}
