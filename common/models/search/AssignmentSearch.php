<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Assignment;

/**
 * AssignmentSearch represents the model behind the search form of `common\models\Assignment`.
 */
class AssignmentSearch extends Assignment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asg_id', 'sub_cat_proj_id', 'cat_proj_id', 'sts_asg_id', 'deleted'], 'integer'],
            [['asg_title', 'asg_description', 'asg_start_time', 'asg_end_time', 'asg_year', 'class', 'deleted_at', 'deleted_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
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
        $query = Assignment::find();

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
            'asg_id' => $this->asg_id,
            'asg_start_time' => $this->asg_start_time,
            'asg_end_time' => $this->asg_end_time,
            'sub_cat_proj_id' => $this->sub_cat_proj_id,
            'cat_proj_id' => $this->cat_proj_id,
            'sts_asg_id' => $this->sts_asg_id,
            'deleted' => $this->deleted,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'asg_title', $this->asg_title])
            ->andFilterWhere(['like', 'asg_description', $this->asg_description])
            ->andFilterWhere(['like', 'asg_year', $this->asg_year])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'deleted_by', $this->deleted_by])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
