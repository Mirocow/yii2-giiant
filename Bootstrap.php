<?php

namespace pafnow\giiant;

use yii\base\Application;
use yii\base\BootstrapInterface;


/**
 * Class Bootstrap
 * @package pafnow\giiant
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('gii')) {
            $app->getModule('gii')->generators['giiant-model'] = 'pafnow\giiant\model\Generator';
            $app->getModule('gii')->generators['giiant-crud'] = 'pafnow\giiant\crud\Generator';
            if ($app instanceof \yii\console\Application) {
                $app->controllerMap['giiant-batch'] = 'pafnow\giiant\commands\BatchController';
            }
        }
    }
}