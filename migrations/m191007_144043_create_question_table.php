<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m191007_144043_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'hint' => $this->string(255)->notNull(),
            'max_ans' => $this->integer(2),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
        $this->addForeignKey(
            'fk-question_quiz_id',
            'question',
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
        $this->dropTable('{{%question}}');
    }
}
