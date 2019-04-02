<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sippm_project_usage".
 *
 * @property int $proj_usg_id
 * @property string $proj_usg_usage
 * @property int $proj_id
 * @property int $sts_proj_usg_id
 * @property int $cat_usg_id
 * @property int $deleted
 * @property string $deleted_at
 * @property string $deleted_by
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property SippmCategoryUsage $catUsg
 * @property SippmStatusProjectUsage $stsProjUsg
 */
class ProjectUsage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sippm_project_usage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proj_id', 'sts_proj_usg_id', 'cat_usg_id', 'deleted'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['proj_usg_usage'], 'string', 'max' => 500],
            [['deleted_by', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['cat_usg_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryUsage::className(), 'targetAttribute' => ['cat_usg_id' => 'cat_usg_id']],
            [['sts_proj_usg_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusProjectUsage::className(), 'targetAttribute' => ['sts_proj_usg_id' => 'sts_proj_usg_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
   

        return [
            'proj_usg_id' => 'Proj Usg ID',
                            
            'proj_usg_usage' => 'Deskripsi Penggunaan',

            'proj_id' => 'Proj ID',
            'sts_proj_usg_id' => 'Sts Proj Usg ID',
            'cat_usg_id' => 'Cat Usg ID',
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
    public function getCatUsg()
    {
        return $this->hasOne(SippmCategoryUsage::className(), ['cat_usg_id' => 'cat_usg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStsProjUsg()
    {
        return $this->hasOne(SippmStatusProjectUsage::className(), ['sts_proj_usg_id' => 'sts_proj_usg_id']);
    }
}