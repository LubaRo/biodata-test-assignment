<?php

use yii\db\Migration;

/**
 * Class m210505_061734_create_table_bonus
 */
class m210505_061734_create_table_bonus extends Migration
{
    public function up()
    {
        $this->createTable('{{%bonus}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string()->notNull(),
            'quantity'    => $this->integer()->notNull()->defaultValue(0),
            'is_infinite' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        $this->batchInsert('{{%bonus}}', ['name', 'quantity', 'is_infinite'], [
                ['Бесплатное обследование', 10, false],
                ['Скидка на поездку в санаторий', 0, true],
                ['Кружка с логотипом "БиоДата"', 30, false]
            ]
        );
    }

    public function down()
    {
        $this->truncateTable('{{%bonus}}');
        $this->dropTable('{{%bonus}}');
    }
}
