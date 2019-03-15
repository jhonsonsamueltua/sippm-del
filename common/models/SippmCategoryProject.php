<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_category_project".
 *
 * @property int $cat_proj_id
 * @property string $cat_proj_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmAssignment[] $sippmAssignments
 */
class SippmCategoryProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sippm_category_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['cat_proj_name'], 'string', 'max' => 32],
            [['deleted'], 'string', 'max' => 1],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_proj_id' => 'Cat Proj ID',
            'cat_proj_name' => 'Cat Proj Name',
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
    public function getSippmAssignments()
    {
        return $this->hasMany(SippmAssignment::className(), ['cat_proj_id' => 'cat_proj_id']);
    }
}
