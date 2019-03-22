<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_status_win".
 *
 * @property int $sts_win_id
 * @property string $sts_win_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmProject[] $sippmProjects
 */
class SippmStatusWin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_status_win';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['sts_win_name'], 'string', 'max' => 32],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sts_win_id' => 'Sts Win ID',
            'sts_win_name' => 'Sts Win Name',
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
    public function getSippmProjects()
    {
        return $this->hasMany(SippmProject::className(), ['sts_win_id' => 'sts_win_id']);
    }
}
