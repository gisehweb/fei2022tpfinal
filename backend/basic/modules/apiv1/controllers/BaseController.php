<?php

namespace app\modules\apiv1\controllers;


use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;


/**
 * Default controller for the `apiv1` module
 * *@return array Lista de dominios que pueden acceder a la api
 */
class BaseController extends ActiveController
{
    public static function allowedDomains()
    {
        return [$_SERVER["REMOTE_ADDR"], 'http://localhost:8080'];
    }


    public function behaviors()
    {

        /* $behaviors['authenticator']['authMethods'] = [HttpBearerAuth::class];
        return $behaviors; */
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'corsFilter'  => [
                'class' => Cors::class,
                'cors'  => [
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                    'Access-Control-Allow-Headers' => ['authorization', 'X-Requested-With', 'content-type']
                ],
            ],
        ]);
    }
}