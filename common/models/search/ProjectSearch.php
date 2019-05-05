<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Project;

/**
 * ProjectSearch represents the model behind the search form of `common\models\SippmProject`.
 */
class ProjectSearch extends Project
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proj_id', 'proj_downloaded', 'sts_win_id', 'deleted'], 'integer'],
            [['proj_title', 'proj_description', 'deleted_at', 'deleted_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
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
        $query = Project::find();

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
            'proj_downloaded' => $this->proj_downloaded,
            'sts_win_id' => $this->sts_win_id,
            'deleted' => $this->deleted,
        ]);

        $query->orFilterWhere(['like', 'proj_title', $this->proj_title])
            ->orFilterWhere(['like', 'proj_description', $this->proj_description])
            ->andFilterWhere(['like', 'proj_cat_name', $this->proj_cat_name])
            ->andFilterWhere(['not', ['deleted' => 1]]);

        return $dataProvider;
    }
}
