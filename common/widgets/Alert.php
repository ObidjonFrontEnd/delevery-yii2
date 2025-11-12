<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Alert extends Widget
{
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        if (empty($flashes)) {
            return '';
        }

        $output = '';
        foreach ($flashes as $type => $messages) {
            foreach ((array)$messages as $message) {
                $color = $this->getColor($type);

                $output .= Html::tag('div',
                    Html::encode($message),
                    [
                        'class' => "alert my-2 p-4 rounded-lg text-white {$color} shadow-md transition-all duration-300",
                        'role' => 'alert',
                    ]
                );
            }
            $session->removeFlash($type);
        }

        return $output;
    }

    private function getColor($type)
    {
        return match ($type) {
            'error', 'danger' => 'bg-red-500 hover:bg-red-600',
            'success' => 'bg-green-500 hover:bg-green-600',
            'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-black',
            'info' => 'bg-blue-500 hover:bg-blue-600',
            default => 'bg-gray-500 hover:bg-gray-600',
        };
    }
}
