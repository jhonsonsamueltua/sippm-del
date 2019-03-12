<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_course".
 *
 * @property int $course_id
 * @property string $course_name
 * @property string $course_alias
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmAssignment[] $sippmAssignments
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['course_name', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['course_alias'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'course_id' => 'Course ID',
            'course_name' => 'Course Name',
            'course_alias' => 'Course Alias',
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
        return $this->hasMany(SippmAssignment::className(), ['course_id' => 'course_id']);
    }
}
