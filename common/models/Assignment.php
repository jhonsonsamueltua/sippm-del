<?php

namespace common\models;
use kop\y2cv\ConditionalValidator;
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
 * @property int $sub_cat_proj_id
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
 * @property SubCategoryProject $subCatProj
 * @property StatusAssignment $stsAsg
 * @property StudentAssignment[] $sippmStudentAssignments
 */
class Assignment extends \yii\db\ActiveRecord
{
    public $updated_end_time;

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
            [['cat_proj_id', 'sub_cat_proj_id', 'asg_title', 'asg_start_time', 'asg_end_time', 'asg_description', 'asg_year', 'updated_end_time'], 'required', 'message' => "{attribute} tidak boleh kosong."],
            [['asg_start_time', 'asg_end_time', 'updated_end_time', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['sub_cat_proj_id', 'cat_proj_id', 'sts_asg_id', 'deleted'], 'integer'],
            ['asg_start_time', 'date', 'format' => 'php:Y-m-d H:i:s', 'skipOnEmpty' => false],
            ['asg_end_time', 'date', 'format' => 'php:Y-m-d H:i:s', 'skipOnEmpty' => false],
            [['sts_asg_id'], 'default', 'value' => 3],
            [['asg_title', 'asg_creator_email', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 1000],
            [['asg_description'], 'string', 'max' => 500],
            [['asg_creator'], 'string', 'max' => 100],
            [['asg_year', 'class'], 'string', 'max' => 32],
            [['cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryProject::className(), 'targetAttribute' => ['cat_proj_id' => 'cat_proj_id']],
            [['sub_cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategoryProject::className(), 'targetAttribute' => ['sub_cat_proj_id' => 'sub_cat_proj_id']],
            [['sts_asg_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusAssignment::className(), 'targetAttribute' => ['sts_asg_id' => 'sts_asg_id']],
            ['asg_end_time', 'compare', 'compareAttribute' => 'asg_start_time', 'operator' => '>', 'message' => "{attribute} tidak boleh lebih kecil dari Batas Awal."],
            [['updated_end_time', 'asg_start_time'], 'compare', 'compareValue' => date('Y-m-d h:i:s'), 'operator' => '>', 'message' => "{attribute} tidak boleh lebih kecil dari hari ini."],
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
            'updated_end_time' => 'Batas Akhir',
            'asg_year' => 'Tahun Proyek',
            'class' => 'Kelas',
            'asg_creator' => 'Penugas',
            'sub_cat_proj_id' => 'Sub Kategori',
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
    public function getSubCatProj()
    {
        return $this->hasOne(SubCategoryProject::className(), ['sub_cat_proj_id' => 'sub_cat_proj_id']);
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
