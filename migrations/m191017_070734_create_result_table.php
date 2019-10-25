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
            'quiz_name' => $this->string(255),
            'correct_ans' => $this->integer(),
            'min_correct_ans' => $this->integer(),
            'question_count' => $this->integer(),
            'created_at' => $this->integer(11),
            'created_by' => $this->integer(),
        ]);
        $this->addForeignKey(
            'result_user_id_fk',
            'result',
            'created_by',
            'user',
            'id',
            'SET NULL'
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
