<?php

namespace app\models;

/**
 * Extends \yii\db\ActiveRecord for custom functionality
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Gets model by given id... Just a naming convention
     * @param Int $id
     * @return mixed either object or null if not found
     */
    public static function findById($id)
    {
        return static::find($id);
    }
}