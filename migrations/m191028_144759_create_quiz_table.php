<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz}}`.
 */
class m191028_144759_create_quiz_table extends Migration
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
            'certification_valid' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
        $this->addForeignKey(
            'quiz_user_id_fk',
            'quiz',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'quiz_user_id_fk_2',
            'quiz',
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
        $this->dropTable('{{%quiz}}');
    }
}
