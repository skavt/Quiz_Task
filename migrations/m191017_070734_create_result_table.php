<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%result}}`.
 */
class m191017_070734_create_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%result}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer(),
            'correct_ans' => $this->integer(),
            'min_correct_ans' => $this->integer(),
            'created_at' => $this->integer(11),
        ]);

        $this->addForeignKey(
            'fk-result_quiz_id',
            'result',
            'quiz_id',
            'quiz',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}');
    }
}
