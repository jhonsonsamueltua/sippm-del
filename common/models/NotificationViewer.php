<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_notification_viewer".
 *
 * @property int $ntf_viewer_id
 * @property int $ntf_id
 * @property string $ntf_reader
 *
 * @property SippmNotification $ntf
 */
class NotificationViewer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_notification_viewer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ntf_id', 'ntf_reader'], 'required'],
            [['ntf_id'], 'integer'],
            [['ntf_reader'], 'string', 'max' => 100],
            [['ntf_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmNotification::className(), 'targetAttribute' => ['ntf_id' => 'ntf_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ntf_viewer_id' => 'Ntf Viewer ID',
            'ntf_id' => 'Ntf ID',
            'ntf_reader' => 'Ntf Reader',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNtf()
    {
        return $this->hasOne(SippmNotification::className(), ['ntf_id' => 'ntf_id']);
    }
}
