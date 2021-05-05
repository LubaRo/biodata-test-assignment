<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property string $name
 * @property int $quantity
 * @property int $is_infinite
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['quantity', 'is_infinite'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'quantity' => 'Quantity',
            'is_infinite' => 'Is Infinite',
        ];
    }

    protected static function getAvailableBonusesCondition()
    {
        return 'is_infinite = 1 OR quantity > 0';
    }

    /**
     * @return array|null
     */
    public static function findAvailableBonuses()
    {
        return static::find()
            ->where(static::getAvailableBonusesCondition())
            ->all();
    }

    /**
     * @return bool
     */
    public static function isAvailableToChoose()
    {
        return static::find()
            ->where(static::getAvailableBonusesCondition())
            ->count() > 0;
    }
}
