<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m191007_144905_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'is_correct' => $this->boolean(0),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
        $this->addForeignKey(
            'fk-answer_question_id',
            'answer',
            'question_id',
            'question',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answer}}');
    }
}
