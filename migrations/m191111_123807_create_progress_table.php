<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%progress}}`.
 */
class m191111_123807_create_progress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%progress}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer(),
            'question_id' => $this->integer(),
            'selected_answer' => $this->string(255),
            'is_correct' => $this->boolean(),
            'last_question' => $this->integer(),
            'created_at' => $this->integer(),
            'passed_by' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk_progress_user_id',
            'progress',
            'passed_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%progress}}');
    }
}
