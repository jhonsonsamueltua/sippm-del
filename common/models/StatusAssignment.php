<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_status_assignment".
 *
 * @property int $sts_asg_id
 * @property string $sts_asg_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Assignment[] $sippmAssignments
 */
class StatusAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sippm_status_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['sts_asg_name'], 'string', 'max' => 32],
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
            'sts_asg_id' => 'Sts Asg ID',
            'sts_asg_name' => 'Sts Asg Name',
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
        return $this->hasMany(Assignment::className(), ['sts_asg_id' => 'sts_asg_id']);
    }
}
