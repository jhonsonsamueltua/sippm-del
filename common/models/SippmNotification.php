<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_notification".
 *
 * @property int $ntf_id
 * @property string $ntf_type
 * @property string $ntf_description
 * @property int $ntf_seen
 * @property string $user_username
 * @property int $asg_id
 * @property int $proj_usg_id
 * @property string $created_at
 *
 * @property SippmAssignment $asg
 * @property SippmProjectUsage $projUsg
 */
class SippmNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ntf_type', 'user_username', 'created_at'], 'required'],
            [['ntf_seen', 'asg_id', 'proj_usg_id'], 'integer'],
            [['created_at'], 'safe'],
            [['ntf_type', 'user_username'], 'string', 'max' => 100],
            [['asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => Assignment::className(), 'targetAttribute' => ['asg_id' => 'asg_id']],
            [['proj_usg_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectUsage::className(), 'targetAttribute' => ['proj_usg_id' => 'proj_usg_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ntf_id' => 'Ntf ID',
            'ntf_type' => 'Ntf Type',
            'ntf_seen' => 'Ntf Seen',
            'user_username' => 'User Username',
            'asg_id' => 'Asg ID',
            'proj_usg_id' => 'Proj Usg ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsg()
    {
        return $this->hasOne(Assignment::className(), ['asg_id' => 'asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjUsg()
    {
        return $this->hasOne(ProjectUsage::className(), ['proj_usg_id' => 'proj_usg_id']);
    }
}
