<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student}}`.
 */
class m210108_031441_create_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'code' => $this->string(15)->notNull()->unique(),
            'gender' => $this->boolean()->notNull()->defaultValue(1),
            'age' => $this->integer(3),
            'address' => $this->text(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210108_031441_create_student_table can't be reverted.\n";
        $this->dropTable('{{%student}}');
        return false;
    }
}
