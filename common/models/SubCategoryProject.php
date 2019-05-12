<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_sub_cat_proj".
 *
 * @property int $sub_cat_proj_id
 * @property string $sub_cat_proj_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmAssignment[] $sippmAssignments
 * @property CategoryProject $categoryProject
 */
class SubCategoryProject extends \yii\db\ActiveRecord
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
        return 'sippm_sub_category_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sub_cat_proj_name'], 'required', 'message' => '{attribute} tidak boleh kosong.'],
            [['sub_cat_proj_id', 'cat_proj_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['sub_cat_proj_name', 'deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['cat_proj_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryProject::className(), 'targetAttribute' => ['cat_proj_id' => 'cat_proj_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sub_cat_proj_id' => 'Sub Category ID',
            'sub_cat_proj_name' => 'Nama Sub Kategori',
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
        return $this->hasMany(Assignment::className(), ['sub_cat_proj_id' => 'sub_cat_proj_id']);
    }

    public function getCatProj()
    {
        return $this->hasOne(CategoryProject::className(), ['cat_proj_id' => 'cat_proj_id']);
    }
}
