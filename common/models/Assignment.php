<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_assignment".
 *
 * @property int $asg_id
 * @property string $asg_title
 * @property string $asg_description
 * @property string $asg_start_time
 * @property string $asg_end_time
 * @property string $asg_year
 * @property string $class
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
 * @property CategoryProject $catProj
 * @property Course $course
 * @property StatusAssignment $stsAsg
 * @property StudentAssignment[] $sippmStudentAssignments
 */
class Assignment extends \yii\db\ActiveRecord
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
        return 'sippm_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asg_start_time', 'asg_end_time', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['course_id', 'cat_proj_id', 'sts_asg_id', 'deleted'], 'integer'],
            [['asg_title', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['asg_description'], 'string', 'max' => 500],
            [['asg_year', 'class'], 'string', 'max' => 32],
            [['cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryProject::className(), 'targetAttribute' => ['cat_proj_id' => 'cat_proj_id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['sts_asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusAssignment::className(), 'targetAttribute' => ['sts_asg_id' => 'sts_asg_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'asg_id' => 'Asg ID',
            'asg_title' => 'Asg Title',
            'asg_description' => 'Asg Description',
            'asg_start_time' => 'Asg Start Time',
            'asg_end_time' => 'Asg End Time',
            'asg_year' => 'Asg Year',
            'class' => 'Class',
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
        return $this->hasOne(CategoryProject::className(), ['cat_proj_id' => 'cat_proj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStsAsg()
    {
        return $this->hasOne(StatusAssignment::className(), ['sts_asg_id' => 'sts_asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(StudentAssignment::className(), ['asg_id' => 'asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(ClassAssignment::className(), ['asg_id' => 'asg_id']);
    }
}
