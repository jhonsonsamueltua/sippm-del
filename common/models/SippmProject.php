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
 * @property SippmFile[] $sippmFiles
 * @property SippmStatusProject $stsProj
 * @property SippmStatusWin $stsWin
 * @property SippmStudentProject[] $sippmStudentProjects
 */
class SippmProject extends \yii\db\ActiveRecord
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
            [['proj_downloaded', 'sts_win_id', 'sts_proj_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['proj_title', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['proj_description'], 'string', 'max' => 500],
            [['files'], 'file', 'maxFiles' => 0],
            [['sts_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmStatusProject::className(), 'targetAttribute' => ['sts_proj_id' => 'sts_proj_id']],
            [['sts_win_id'], 'exist', 'skipOnError' => true, 'targetClass' => SippmStatusWin::className(), 'targetAttribute' => ['sts_win_id' => 'sts_win_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proj_id' => 'Proj ID',
            'proj_title' => 'Project Title',
            'proj_description' => 'Project Description',
            'proj_downloaded' => 'Proj Downloaded',
            'sts_win_id' => 'Win Status',
            'sts_proj_id' => 'Project Status',
            'files' => 'Upload proyek',
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
        return $this->hasMany(SippmFile::className(), ['proj_id' => 'proj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStsProj()
    {
        return $this->hasOne(SippmStatusProject::className(), ['sts_proj_id' => 'sts_proj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStsWin()
    {
        return $this->hasOne(SippmStatusWin::className(), ['sts_win_id' => 'sts_win_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSippmStudentProjects()
    {
        return $this->hasMany(SippmStudentProject::className(), ['proj_id' => 'proj_id']);
    }
}
