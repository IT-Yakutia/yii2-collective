<?php

namespace ityakutia\collective;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ityakutia\collective\controllers';
    public $defaultRoute = 'collective';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}