<?php

namespace app\modules\api\v1;

class module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    public function init()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        parent::init();
    }
}
