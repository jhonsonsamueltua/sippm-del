<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_student".
 *
 * @property int $stu_id
 * @property string $stu_fullname
 * @property string $stu_email
 * @property string $stu_nim
 * @property int $cls_id
 * @property int $user_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmClass $cls
 * @property User $user
 * @property SippmStudentAssignment[] $sippmStudentAssignments
 * @property SippmStudentProject[] $sippmStudentProjects
 */
class Student extends \yii\db\ActiveRecord
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
        return 'sippm_student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cls_id', 'user_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['stu_fullname', 'stu_email', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['stu_nim'], 'string', 'max' => 32],
            [['cls_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmClass::className(), 'targetAttribute' => ['cls_id' => 'cls_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stu_id' => 'Stu ID',
            'stu_fullname' => 'Stu Fullname',
            'stu_email' => 'Stu Email',
            'stu_nim' => 'Stu Nim',
            'cls_id' => 'Cls ID',
            'user_id' => 'User ID',
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
    public function getCls()
    {
        return $this->hasOne(SippmClass::className(), ['cls_id' => 'cls_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudentAssignments()
    {
        return $this->hasMany(SippmStudentAssignment::className(), ['stu_id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudentProjects()
    {
        return $this->hasMany(SippmStudentProject::className(), ['stu_id' => 'stu_id']);
    }
}
