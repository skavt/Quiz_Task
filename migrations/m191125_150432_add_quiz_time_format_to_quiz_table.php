<?php

use yii\db\Migration;

/**
 * Class m191125_150432_add_quiz_time_format_to_quiz_table
 */
class m191125_150432_add_quiz_time_format_to_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quiz', 'quiz_time_format', $this->string(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191125_150432_add_quiz_time_format_to_quiz_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_150432_add_quiz_time_format_to_quiz_table cannot be reverted.\n";

        return false;
    }
    */
}
