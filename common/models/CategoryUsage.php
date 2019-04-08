<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_category_usage".
 *
 * @property int $cat_usg_id
 * @property string $cat_usg_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmProjectUsage[] $sippmProjectUsages
 */
class CategoryUsage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_category_usage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['cat_usg_name'], 'string', 'max' => 32],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cat_usg_id' => 'Cat Usg ID',
            'cat_usg_name' => 'Cat Usg Name',
            'deleted' => 'Deleted',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmProjectUsages()
    {
        return $this->hasMany(SippmProjectUsage::className(), ['cat_usg_id' => 'cat_usg_id']);
    }
}
