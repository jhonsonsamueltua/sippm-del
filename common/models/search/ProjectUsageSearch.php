<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProjectUsage;

/**
 * ProjectUsageSearch represents the model behind the search form of `common\models\ProjectUsage`.
 */
class ProjectUsageSearch extends ProjectUsage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proj_usg_id', 'proj_id', 'sts_proj_usg_id', 'cat_usg_id', 'deleted'], 'integer'],
            [['proj_usg_usage', 'deleted_at', 'deleted_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProjectUsage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'proj_usg_id' => $this->proj_usg_id,
            'proj_id' => $this->proj_id,
            'sts_proj_usg_id' => $this->sts_proj_usg_id,
            'cat_usg_id' => $this->cat_usg_id,
            'deleted' => $this->deleted,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'proj_usg_usage', $this->proj_usg_usage])
            ->andFilterWhere(['like', 'deleted_by', $this->deleted_by])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
