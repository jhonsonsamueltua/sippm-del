<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_student_assignment".
 *
 * @property int $stu_asg_id
 * @property int $stu_id
 * @property int $asg_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmAssignment $asg
 * @property SippmStudent $stu
 */
class StudentAssignment extends \yii\db\ActiveRecord
{
    public function behaviors(){
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'delete' => [
                'class' => DeleteBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_student_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cls_asg_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['stu_id'], 'string', 'max' => 20],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['cls_asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassAssignment::className(), 'targetAttribute' => ['cls_asg_id' => 'cls_asg_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stu_asg_id' => 'Stu Asg ID',
            'stu_id' => 'Stu ID',
            'cls_asg_id' => 'Cls Asg ID',
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
    public function getClasses()
    {
        return $this->hasOne(ClassAssignment::className(), ['cls_asg_id' => 'cls_asg_id']);
    }

}