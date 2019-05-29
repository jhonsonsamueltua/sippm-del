<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use thyseus\validators\WordValidator;
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
    public $files, $winProof;

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
            ['proj_win_rank', 'required', 'when' => function($model){
                return $model->sts_win_id == '1';
            }, 'whenClient' => "function(attribute, value){
                return $('#project-sts_win_id').val() == '1';
            }", 'message' => '{attribute} tidak boleh kosong'],
            [['proj_downloaded', 'sts_win_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['proj_cat_name', 'proj_win_rank', 'proj_year', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['proj_win_proof'], 'string', 'max' => 1000],
            [['proj_title'], WordValidator::className(),
                'min' => 3,
                'max' => 20,
                'messages'  => array(
                    'max' => 'Judul Proyek tidak boleh lebih dari 20 kata.',
                    'min' => 'Judul Proyek tidak boleh kurang dari 3 kata.',
                    ),
                ],
            [['proj_description'], WordValidator::className(),
                'min' => 50,
                'max' => 200,
                'messages'  => array(
                    'max' => 'Deskripsi Proyek tidak boleh lebih dari 200 kata.',
                    'min' => 'Deskripsi Proyek tidak boleh kurang dari 50 kata.',
                ),
            ],
            ['proj_author', 'string','min' => 5, 'max' => 500, 'tooShort' => '{attribute} tidak boleh kurang dari 5 karakter.', 'tooLong' => '{attribute} tidak boleh lebih dari 500 karakter.'],
            [['proj_creator_class'], 'string', 'max' => 100],  
            ['proj_author', 'match', 'pattern'=> '/^[A-Za-z; ]+$/u', 'message'=> 'Penulis hanya dapat terdiri dari karakter [ a-z A-Z ; ].'],
            ['proj_keyword', 'match', 'pattern'=> '/^[A-Z0-9a-z; ]+$/u', 'message'=> 'Kata Kuncti hanya dapat terdiri dari karakter [ a-z A-Z ; ].'],
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
            'proj_win_rank' => 'Peringkat',
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
