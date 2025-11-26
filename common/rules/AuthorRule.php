<?php
namespace common\rules;
class AuthorRule extends \yii\rbac\Rule
{
    public $name = 'isAuthor';
    public function execute($user, $item, $params){
        return isset($params['restaurants']) ? $params['restaurants']->user_id == $user : false;
    }
}