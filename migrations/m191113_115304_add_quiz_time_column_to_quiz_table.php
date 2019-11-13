<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%quiz}}`.
 */
class m191113_115304_add_quiz_time_column_to_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('quiz', 'quiz_time', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('quiz', 'quiz_time');
    }
}
