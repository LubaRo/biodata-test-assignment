<?php

use yii\db\Migration;

/**
 * Class m210505_144733_add_bonus_info_to_user
 */
class m210505_144733_add_bonus_info_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'bonus_id', $this->integer()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'bonus_id');
    }
}
