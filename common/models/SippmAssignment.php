<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sippm_assignment".
 *
 * @property int $asg_id
 * @property string $asg_title
 * @property string $asg_description
 * @property string $asg_start_time
 * @property string $asg_end_time
 * @property string $asg_year
 * @property int $cls_id
 * @property int $course_id
 * @property int $cat_proj_id
 * @property int $sts_asg_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmCategoryProject $catProj
 * @property SippmClass $cls
 * @property SippmStatusAssignment $stsAsg
 * @property SippmStudentAssignment[] $sippmStudentAssignments
 */
class SippmAssignment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sippm_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['asg_start_time', 'asg_end_time', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['cls_id', 'course_id', 'cat_proj_id', 'sts_asg_id'], 'integer'],
            [['asg_title', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['asg_description'], 'string', 'max' => 500],
            [['asg_year'], 'string', 'max' => 32],
            [['deleted'], 'string', 'max' => 1],
            [['cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmCategoryProject::className(), 'targetAttribute' => ['cat_proj_id' => 'cat_proj_id']],
            [['cls_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmClass::className(), 'targetAttribute' => ['cls_id' => 'cls_id']],
            [['sts_asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmStatusAssignment::className(), 'targetAttribute' => ['sts_asg_id' => 'sts_asg_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'asg_id' => 'Asg ID',
            'asg_title' => 'Title',
            'asg_description' => 'Description',
            'asg_start_time' => 'Start Time',
            'asg_end_time' => 'End Time',
            'asg_year' => 'Year',
            'cls_id' => 'Cls ID',
            'course_id' => 'Course ID',
            'cat_proj_id' => 'Cat Proj ID',
            'sts_asg_id' => 'Sts Asg ID',
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
    public function getCatProj()
    {
        return $this->hasOne(SippmCategoryProject::className(), ['cat_proj_id' => 'cat_proj_id']);
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
    public function getStsAsg()
    {
        return $this->hasOne(SippmStatusAssignment::className(), ['sts_asg_id' => 'sts_asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudentAssignments()
    {
        return $this->hasMany(SippmStudentAssignment::className(), ['asg_id' => 'asg_id']);
    }
}
