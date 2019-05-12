<?php

namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use common\behaviors\BlameableBehavior;
use common\behaviors\DeleteBehavior;

/**
 * This is the model class for table "sippm_category_project".
 *
 * @property int $cat_proj_id
 * @property string $cat_proj_name
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Assignment[] $sippmAssignments
 */
class CategoryProject extends \yii\db\ActiveRecord
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sippm_category_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_proj_name'], 'required', 'message' => '{attribute} tidak boleh kosong'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['cat_proj_name'], 'string', 'max' => 32],
            [['deleted'], 'integer'],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_proj_id' => 'Cat Proj ID',
            'cat_proj_name' => 'Nama Kategori',
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
        return $this->hasMany(Assignment::className(), ['cat_proj_id' => 'cat_proj_id']);
    }

    public function getSubCat()
    {
        return $this->hasMany(SubCategoryAssignment::className(), ['cat_proj_id' => 'cat_proj_id']);
    }
}
