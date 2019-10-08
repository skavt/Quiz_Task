<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz}}`.
 */
class m191007_143918_create_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(127)->notNull(),
            'min_correct_ans' => $this->integer(2)->notNull(),
            'max_questions' => $this->integer(2),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz}}');
    }
}
