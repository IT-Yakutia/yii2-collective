<?php

namespace ityakutia\collective;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app)
    {
        $app->setModule('collective', 'ityakutia\collective\Module');
    }
}