<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%result}}`.
 */
class m191025_100022_add_certification_valid_column_to_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%result}}', 'certification_valid', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%result}}', 'certification_valid');
    }
}
