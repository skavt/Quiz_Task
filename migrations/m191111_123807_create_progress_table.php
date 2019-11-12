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
            'selected_answer' => $this->integer(),
            'is_correct' => $this->boolean(),
            'last_question' => $this->boolean(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk_progress_user_id',
            'progress',
            'created_by',
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
