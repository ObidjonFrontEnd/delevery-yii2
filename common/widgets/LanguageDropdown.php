<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class LanguageDropdown extends Widget
{
    public function run()
    {
        $current = Yii::$app->language;

        // Список языков с названиями и флагами
        $languages = [
            'en' => ['name' => Yii::t('app', 'English'), 'flag' => 'default.jpg'],
            'ru' => ['name' => Yii::t('app', 'Russian'), 'flag' => 'default.jpg'],
            'uz' => ['name' => Yii::t('app', 'Uzbek'), 'flag' => 'default.jpg'],
        ];

        // Формируем dropdown элементы для других языков
        $items = '';
        foreach ($languages as $code => $lang) {
            if ($code === $current) continue;

            $items .= Html::tag('div',
                Html::a(
                    '<span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="'
                    . Yii::getAlias('@web/image/' . $languages[$current]['flag'])
                    . '" alt="" />
                     </span>' . $lang['name'],
                    ['/' . Yii::$app->controller->route, 'language' => $code],
                    ['class' => 'menu-link d-flex px-5']
                ),
                ['class' => 'menu-item px-3']
            );
        }


        return Html::tag('div',
            Html::tag('a',
                '<span class="menu-title position-relative">'
                . Yii::t('app', 'Language') .
                '<span class="fs-8 rounded bg-light capitalize px-3 py-2 position-absolute translate-middle-y top-50 end-0">'
                . strtoupper($current) .
                '</span>'
                . '</span>'
                . '<img class="w-15px h-15px rounded-1 ms-2" src="'
                . Yii::getAlias('@web/image/' . $languages[$current]['flag'])
                . '" alt="" />',
                ['class' => 'menu-link px-5', 'href' => '#']
            )
            . Html::tag('div', $items, ['class' => 'menu-sub menu-sub-dropdown w-175px py-4']),
            [
                'class' => 'menu-item px-5',
                'data-kt-menu-trigger' => '{default: "click", lg: "hover"}',
                'data-kt-menu-placement' => 'right-end',
                'data-kt-menu-offset' => '-15px, 0'
            ]
        );

    }
}
