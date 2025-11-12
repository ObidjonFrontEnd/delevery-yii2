<?php
namespace frontend\widgets;

use yii\base\Widget;

class WishlistWidget extends Widget
{
    public $arr = [];

    public function run()
    {
        return $this->render('_wishlist', [
            'arr' => $this->arr,
        ]);
    }
}
