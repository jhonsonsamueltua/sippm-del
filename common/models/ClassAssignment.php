<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_class_assignment".
 *
 * @property int $cls_asg_id
 * @property string $class
 * @property int $asg_id
 *
 * @property SippmAssignment $asg
 */
class ClassAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_class_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class', 'asg_id'], 'required'],
            [['asg_id'], 'integer'],
            [['class'], 'string', 'max' => 100],
            [['asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => Assignment::className(), 'targetAttribute' => ['asg_id' => 'asg_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cls_asg_id' => 'Cls Asg ID',
            'class' => 'Class',
            'asg_id' => 'Asg ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsg()
    {
        return $this->hasOne(SippmAssignment::className(), ['asg_id' => 'asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(StudentAssignment::className(), ['cls_asg_id' => 'cls_asg_id']);
    }
}
