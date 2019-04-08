<?php

namespace common\models;

use Yii;

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
            [['proj_downloaded', 'sts_win_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['proj_title', 'proj_cat_name', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['proj_description'], 'string', 'max' => 500],
            [['proj_cat_name'], 'string', 'max' => 100],
            [['files'], 'file', 'maxFiles' => 0],
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
