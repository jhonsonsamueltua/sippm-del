<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_project".
 *
 * @property int $proj_id
 * @property string $proj_title
 * @property string $proj_description
 * @property int $proj_downloaded
 * @property int $sts_win_id
 * @property int $sts_proj_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property File[] $sippmFiles
 * @property StatusWin $stsWin
 * @property StudentProject[] $sippmStudentProjects
 * @property CategoryProject $catProj
 */
class Project extends \yii\db\ActiveRecord
{
    public $files;

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
        return 'sippm_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proj_title', 'proj_description', 'proj_author', 'proj_keyword'], 'required', 'message' => "{attribute} tidak boleh kosong."],
            [['proj_downloaded', 'sts_win_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['proj_cat_name', 'proj_year', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['proj_keyword'], 'string', 'max' => 1000],
            [['proj_description', 'proj_title'], 'string'],
            [['proj_author'], 'string', 'max' => 500],
            [['proj_creator_class'], 'string', 'max' => 100],
            ['proj_author', 'match', 'pattern'=> '/^[A-Za-z; ]+$/u', 'message'=> 'Penulis hanya dapat terdiri dari karakter [ a-z A-Z ; ].'],
            ['proj_keyword', 'match', 'pattern'=> '/^[A-Z0-9a-z; ]+$/u', 'message'=> 'Kata Kuncti hanya dapat terdiri dari karakter [ a-z A-Z ; ].'],
            // [['files'], 'file','extensions' => 'pdf, jpg, zip', 'maxSize' => 1024 * 1024 * 512, 'tooBig' => 'Ukuran Maksimal 500 MB.'],
            [['sts_win_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusWin::className(), 'targetAttribute' => ['sts_win_id' => 'sts_win_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proj_id' => 'ID Proyek',
            'proj_title' => 'Judul Proyek',
            'proj_description' => 'Deskripsi Proyek',
            'proj_downloaded' => 'Jumlah Diunduh',
            'proj_cat_name' => 'Kategori proyek',
            'proj_author' => 'Penulis',
            'proj_keyword' => 'Keyword',
            'proj_year' => 'Tahun',
            'sts_win_id' => 'Status Menang',
            'files' => 'Unggah Proyek',
            'deleted' => 'Deleted',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getAsg()
    {
        return $this->hasOne(Assignment::className(), ['asg_id' => 'asg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmFiles()
    {
        return $this->hasMany(File::className(), ['proj_id' => 'proj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStsWin()
    {
        return $this->hasOne(StatusWin::className(), ['sts_win_id' => 'sts_win_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudentProjects()
    {
        return $this->hasMany(StudentProject::className(), ['proj_id' => 'proj_id']);
    }
}
