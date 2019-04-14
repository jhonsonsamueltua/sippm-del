<?php

namespace common\models;
use kop\y2cv\ConditionalValidator;
use Yii;

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
            [['cat_proj_id', 'asg_title', 'asg_start_time', 'asg_end_time', 'asg_description'], 'required', 'message' => "{attribute} tidak boleh kosong."],
            // ['course_id', 'required', 'when' => function($model) {
            //     return $model->cat_proj_id == 1;
            // }, 'enableClientValidation' => false],

            // ['course_id', 'required', 'when' => function ($model) {
            //     return $model->cat_proj_id == 1;
            //   }, 'whenClient' => "function (attribute, value) {
            //     return $('#cat_proj_id').val() == 1;
            //   }"],

            // ['course_id', 'required', 'whenClient' => function($model) {
            //         return $model->cat_proj_id == 1;
            // }, 'enableClientValidation' => false],
            [['asg_start_time', 'asg_end_time', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['course_id', 'cat_proj_id', 'sts_asg_id', 'deleted'], 'integer'],
            ['asg_start_time', 'date', 'format' => 'php:Y-m-d H:i:s', 'skipOnEmpty' => false],
            ['asg_end_time', 'date', 'format' => 'php:Y-m-d H:i:s', 'skipOnEmpty' => false],
            [['sts_asg_id'], 'default', 'value' => 1],
            [['asg_title', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['asg_description'], 'string', 'max' => 500],
            [['asg_year', 'class'], 'string', 'max' => 32],
            [['cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryProject::className(), 'targetAttribute' => ['cat_proj_id' => 'cat_proj_id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['sts_asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusAssignment::className(), 'targetAttribute' => ['sts_asg_id' => 'sts_asg_id']],
            ['asg_end_time', 'compare', 'compareAttribute' => 'asg_start_time', 'operator' => '>', 'message' => "{attribute} tidak boleh lebih kecil dari Batas Awal."],
            // [['cat_proj_id'], 'ext.YiiConditionalValidator',
            //     'if' => [
            //         [['cat_proj_id'], 'compare', 'compareValue' => 1]
            //     ],
            //     'then' => [
            //         [['course_id'], 'required']
            //     ]
            // ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'asg_id' => 'Asg ID',
            'asg_title' => 'Judul Penugasan',
            'asg_description' => 'Deskripsi',
            'asg_start_time' => 'Batas Awal',
            'asg_end_time' => 'Batas Akhir',
            'asg_year' => 'Asg Year',
            'class' => 'Kelas',
            'course_id' => 'Matakuliah',
            'cat_proj_id' => 'Kategori',
            'sts_asg_id' => 'Status',
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
