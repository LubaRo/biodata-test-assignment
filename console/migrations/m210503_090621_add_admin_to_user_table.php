<?php

use yii\db\Migration;

/**
 * Class m210503_090621_add_admin_to_user_table
 */
class m210503_090621_add_admin_to_user_table extends Migration
{
    public function up()
    {
        //credentials: admin / 123
        $this->insert('{{%user}}', [
            'username'             => 'admin',
            'email'                => 'admin@test.com',
            'status'               => '10',
            'auth_key'             => Yii::$app->security->generateRandomString(),
            'password_hash'        => Yii::$app->security->generatePasswordHash('123'),
            'password_reset_token' => Yii::$app->security->generateRandomString() . '_' . time(),
            'verification_token'   => Yii::$app->security->generateRandomString() . '_' . time(),
            'is_admin'             => true,
            'created_at'           => time(),
            'updated_at'           => time(),
        ]);
    }

    public function down()
    {
        $this->truncateTable('{{%user}}');
    }
}
