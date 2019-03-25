<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sippm_class".
 *
 * @property int $cls_id
 * @property string $cls_name
 * @property int $prod_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmAssignment[] $sippmAssignments
 * @property SippmProdi $prod
 * @property SippmStudent[] $sippmStudents
 */
class SippmClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sippm_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prod_id'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['cls_name'], 'string', 'max' => 32],
            [['deleted'], 'string', 'max' => 1],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['prod_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmProdi::className(), 'targetAttribute' => ['prod_id' => 'prod_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cls_id' => 'Cls ID',
            'cls_name' => 'Cls Name',
            'prod_id' => 'Prod ID',
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
        return $this->hasMany(SippmAssignment::className(), ['cls_id' => 'cls_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProd()
    {
        return $this->hasOne(SippmProdi::className(), ['prod_id' => 'prod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudents()
    {
        return $this->hasMany(SippmStudent::className(), ['cls_id' => 'cls_id']);
    }
}
