<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Order;

/**
 * OrderSearch represents the model behind the search form of `frontend\models\Order`.
 */
class OrderSearch extends Order
{
    public $globalSearch; // новое свойство для глобального поиска

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'restaurant_id', 'courier_id', 'address_id'], 'integer'],
            [['total'], 'number'],
            [['check_number', 'status', 'payment_status', 'created_at', 'updated_at', 'globalSearch'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // обычные фильтры по колонкам
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'courier_id' => $this->courier_id,
            'total' => $this->total,
            'address_id' => $this->address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'check_number', $this->check_number])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'payment_status', $this->payment_status]);

        // глобальный поиск
        if ($this->globalSearch) {
            $query->orFilterWhere(['like', 'id', $this->globalSearch])
                ->orFilterWhere(['like', 'user_id', $this->globalSearch])
                ->orFilterWhere(['like', 'restaurant_id', $this->globalSearch])
                ->orFilterWhere(['like', 'courier_id', $this->globalSearch])
                ->orFilterWhere(['like', 'total', $this->globalSearch])
                ->orFilterWhere(['like', 'check_number', $this->globalSearch])
                ->orFilterWhere(['like', 'status', $this->globalSearch])
                ->orFilterWhere(['like', 'payment_status', $this->globalSearch]);
        }

        return $dataProvider;
    }
}
